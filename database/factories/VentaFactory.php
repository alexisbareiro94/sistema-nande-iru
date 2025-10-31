<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Venta;
use App\Models\User;
use App\Models\Producto;

class VentaFactory extends Factory
{
    protected $model = Venta::class;

    public function definition(): array
    {
        return [
            'codigo' => generate_code(),            
            'caja_id' => 1, 
            'tenant_id' => 1,
            'cliente_id' => null, 
            'nro_ticket' => $this->faker->unique()->numerify('TKT-#####'),
            'nro_factura' => $this->faker->unique()->numerify('FAC-#####'),
            'cantidad_productos' => 0,
            'forma_pago' => $this->faker->randomElement(['efectivo', 'transferencia']),
            'con_descuento' => $this->faker->boolean(20), 
            'monto_descuento' => null,
            'subtotal' => 0,
            'total' => 0,
            'estado' => 'completado',
            'created_at' => $this->faker->dateTimeBetween('2025-01-01', now()),
            'updated_at' => now(),
            'vendedor_id' => 1,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Venta $venta) {        
            $productos = Producto::inRandomOrder()->take(rand(1, 2))->get();
            $cliente = User::where('role', 'cliente')->inRandomOrder()->first();

            $subtotal = 0;
            $cantidadTotal = 0;

            $cantidad = 0;
            foreach ($productos as $producto) {
                $cantidad = rand(1, 2);
                $producto->ventas += $cantidad;
                $producto->save();
                $precio = $producto->precio_venta;                
                $venta->detalleVentas()->create([
                    'producto_id' => $producto->id, 
                    'tenant_id' => 1,                   
                    'caja_id' => 1,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $producto->precio_venta,
                    'subtotal' => $cantidad * $precio,
                    'total' => $cantidad * $precio,
                    'created_at' => $venta->created_at ?? now(),                    
                ]);

                $subtotal += $cantidad * $precio;
                $cantidadTotal += $cantidad;
            }
            
            $total = $subtotal;
            $monto_descuento = null;

            if ($venta->con_descuento) {
                $descuento = $this->faker->numberBetween(5, 20); 
                $monto_descuento = round($subtotal * ($descuento / 100));
                $total -= round($monto_descuento);
            }            
            $venta->update([
                'cliente_id' => $cliente?->id,
                'tenant_id' => 1,
                'cantidad_productos' => $cantidadTotal,
                'subtotal' => round($subtotal),
                'total' => round($total),
                'monto_descuento' => round($monto_descuento),                
            ]);
            
            $venta->movimiento()->create([
                'caja_id' => 1,  
                'tenant_id' => 1,              
                'venta_id' => $venta->id,
                'tipo' => 'ingreso',
                'concepto' => 'Venta de productos',
                'monto' => $venta->total,
                'created_at' => $venta->created_at ?? now(),
            ]);
            
            $venta->pagos()->create([
                'caja_id' => 1,       
                'tenant_id' => 1,         
                'venta_id' => $venta->id,
                'metodo' => $venta->forma_pago,
                'monto' => $venta->total,
                'estado' => $venta->estado,
            ]);
        });
    }
}
