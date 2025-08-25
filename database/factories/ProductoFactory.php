<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Marca;
use App\Models\Categoria;
use App\Models\Distribuidor;

class ProductoFactory extends Factory
{
    public function definition(): array
    {
        $tipo = $this->faker->randomElement(['producto', 'servicio']);
        $codigoAuto = $this->faker->boolean(50); // 50% chance de generar código

        return [
            'nombre' => $this->faker->words(3, true),
            'tipo' => $tipo,
            // Solo generamos código si no es automático
            'codigo' => $codigoAuto ? null : $this->faker->unique()->regexify('[A-Z0-9]{8}'),
            'marca_id' => $tipo === 'producto' ? Marca::inRandomOrder()->value('id') : null,
            'categoria_id' => Categoria::inRandomOrder()->value('id'),
            'descripcion' => $this->faker->sentence(),
            'stock' => $tipo === 'producto' ? $this->faker->numberBetween(0, 100) : null,
            'stock_minimo' => $tipo === 'producto' ? $this->faker->numberBetween(0, 10) : null,
            'precio_venta' => $this->faker->randomFloat(2, 1, 500),
            'precio_compra' => $tipo === 'producto' ? $this->faker->randomFloat(2, 1, 400) : null,
            'distribuidor_id' => $tipo === 'producto' ? Distribuidor::inRandomOrder()->value('id') : null,
            'imagen' => null,
        ];
    }
}
