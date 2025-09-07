<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Caja;
use App\Models\User;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Pago;
use App\Models\MovimientoCaja;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Venta>
 */
class VentaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Venta::class;
    public function definition(): array
    {
        return [
            'codigo' => generate_code(),
            'caja_id' => Caja::factory(),
            'cliente_id' => User::factory(),
            'cantidad_productos' => 0, // se ajusta luego
            'subtotal' => 0,
            'total' => 0,
            'estado' => 'completado',
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Venta $venta) {
            // Crear entre 2 y 5 detalles
            $detalles = DetalleVenta::factory()
                ->count(rand(1, 5))
                ->create(['venta_id' => $venta->id]);

            $cantidad = $detalles->sum('cantidad');
            $subtotal = $detalles->sum('subtotal');
            $total = $detalles->sum('total');

            $venta->update([
                'cantidad_productos' => $cantidad,
                'subtotal' => $subtotal,
                'total' => $total,
            ]);

            // Generar pagos (1 o 2 si es mixto)
            $metodo = $this->faker->randomElement(['efectivo', 'transferencia', 'mixto']);
            if ($metodo === 'mixto') {
                $monto1 = intval($total * 0.5);
                $monto2 = $total - $monto1;
                $pagos = [
                    ['metodo' => 'efectivo', 'monto' => $monto1],
                    ['metodo' => 'transferencia', 'monto' => $monto2],
                ];
            } else {
                $pagos = [['metodo' => $metodo, 'monto' => $total]];
            }

            foreach ($pagos as $pago) {
                $p = Pago::create([
                    'venta_id' => $venta->id,
                    'metodo' => $pago['metodo'],
                    'monto' => $pago['monto'],
                    'estado' => 'completado',
                ]);

                // Crear movimiento de caja
                MovimientoCaja::create([
                    'caja_id' => $venta->caja_id,
                    'tipo' => 'ingreso',
                    'concepto' => 'Pago venta ' . $venta->codigo,
                    'monto' => $pago['monto'],
                ]);
            }
            // generar un egreso aleatorio (opcional)
            //for($i = 0; $i < 5; $i++){
                if (fake()->boolean(30)) { // 30% de probabilidad
                    MovimientoCaja::create([
                        'caja_id' => $venta->caja_id,
                        'tipo' => 'egreso',
                        'concepto' => fake()->randomElement([
                            'Compra de insumos',
                            'Pago de servicio',
                            'Retiro parcial',
                        ]),
                        'monto' => fake()->numberBetween(20000, 80000),
                    ]);
                }
            //}
        });
    }
}
