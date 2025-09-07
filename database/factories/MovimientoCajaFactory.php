<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MovimientoCaja;
use App\Models\Caja;

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
     protected $model = MovimientoCaja::class;

    public function definition()
    {
        return [
            'caja_id' => Caja::factory(),
            'tipo' => 'ingreso',
            'concepto' => 'Ingreso inicial',
            'monto' => $this->faker->numberBetween(10000, 50000),
        ];
    }
}
