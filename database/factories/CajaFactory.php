<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Caja;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Caja>
 */
class CajaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Caja::class;
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'fecha_apertura' => now(),
            'monto_inicial' => $this->faker->numberBetween(50000, 100000),
            'estado' => 'abierto',
        ];
    }
}
