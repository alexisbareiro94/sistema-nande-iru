<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MovimientoCaja>
 */
class MovimientoCajaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'caja_id' => 1,
            'tenant_id' => 1,
            'tipo' => 'egreso',
            'concepto' => $this->faker->randomElement(['Pago proveedores', 'extraccion', 'compra']),
            'monto' => $this->faker->numberBetween(10000, 500000),
            'created_at' => $this->faker->dateTimeBetween('2025-01-01', now()),
        ];
    }
}
