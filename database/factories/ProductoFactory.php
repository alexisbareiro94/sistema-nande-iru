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
        $codigoAuto = $this->faker->boolean(20); // 50% chance de generar código

        return [
            'nombre' => $this->faker->words(2, true),
            'tipo' => $tipo,            
            'codigo' => $codigoAuto ? null : $this->faker->unique()->regexify('[A-Z0-9]{8}'),
            'marca_id' => $tipo === 'producto' ? Marca::inRandomOrder()->value('id') : null,
            'categoria_id' => Categoria::inRandomOrder()->value('id'),
            'descripcion' => $this->faker->sentence(),
            'stock' => $tipo === 'producto' ? $this->faker->numberBetween(0, 12) : null,
            'stock_minimo' => $tipo === 'producto' ? $this->faker->numberBetween(0, 4) : null,
            'precio_venta' => $this->faker->numberBetween(20000, 425000),
            'precio_compra' => $tipo === 'producto' ? $this->faker->numberBetween(143000, 210000) : null,
            'distribuidor_id' => $tipo === 'producto' ? Distribuidor::inRandomOrder()->value('id') : null,
            'imagen' => null,
        ];
    }
}