<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pago;
use App\Models\Venta;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pago>
 */
class PagoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Pago::class;
    public function definition()
    {
        return [
            'venta_id' => Venta::factory(),
            'metodo' => $this->faker->randomElement(['efectivo', 'transferencia']),
            'monto' => $this->faker->numberBetween(10000, 50000),
            'estado' => 'completado',
        ];
    }
}
