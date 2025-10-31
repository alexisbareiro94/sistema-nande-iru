<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Distribuidor;
use App\Models\Marca;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    public function definition(): array
    {
        $tipo = $this->faker->boolean(90) ? 'producto' : 'servicio';
        $codigoAuto = $this->faker->boolean(20);

        // Primero genero el precio de venta
        $precioVenta = $this->faker->numberBetween(70000, 425000);

        // Si es producto, el precio de compra será menor al de venta
        $precioCompra = $tipo === 'producto'
            ? $this->faker->numberBetween(10000, $precioVenta - 30000) // siempre menor
            : null;

        return [
            'nombre' => $this->faker->words(2, true),
            'tenant_id' => 1,
            'tipo' => $tipo,
            'codigo' => $codigoAuto ? null : $this->faker->unique()->regexify('[A-Z0-9]{8}'),
            'marca_id' => $tipo === 'producto' ? Marca::inRandomOrder()->value('id') : null,
            'categoria_id' => Categoria::inRandomOrder()->value('id'),
            'descripcion' => $this->faker->sentence(),
            'stock' => $tipo === 'producto' ? $this->faker->numberBetween(0, 12) : null,
            'stock_minimo' => $tipo === 'producto' ? $this->faker->numberBetween(0, 4) : null,
            'precio_venta' => $precioVenta,
            'precio_compra' => $precioCompra,
            'distribuidor_id' => $tipo === 'producto' ? Distribuidor::inRandomOrder()->value('id') : null,
            'imagen' => null,
        ];

    }
}
