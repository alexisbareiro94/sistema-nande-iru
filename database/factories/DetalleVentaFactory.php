<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Producto;
use App\Models\DetalleVenta;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetalleVenta>
 */
class DetalleVentaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = DetalleVenta::class;
    public function definition(): array
    {
        $producto = Producto::inRandomOrder()->first() ?? Producto::factory()->create();
        $cantidad = rand(1, 3);
        $precio = $producto->precio ?? $this->faker->numberBetween(10000, 50000);

        return [
            'producto_id' => $producto->id,
            'cantidad' => $cantidad,
            'precio_unitario' => $precio,
            'producto_con_descuento' => false,
            'subtotal' => $cantidad * $precio,
            'total' => $cantidad * $precio,
        ];
    }
}
