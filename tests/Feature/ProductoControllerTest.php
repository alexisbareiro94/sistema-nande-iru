<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Producto;

it('crear producto', function () {
    $data = [
        'nombre' => 'cubierta 175/70R14',
        'codigo' => null,
        'codigo_auto' => true,
        'categoria_id' => 1,
        'marca_id' => 1,
        'descripcion' => null,
        'precio_venta' => 255000,
        'precio_compra' => 155000,
        'stock' => 3,
        'stock_minimo' => 1,
        'distribuidor_id' => 1,
        'tipo' => 'producto',
    ];

    // Hacemos la petición al endpoint store
    $response = $this->postJson('/agregar-producto', $data);

    // Debug (opcional)
    dump($response->json());

    // Afirmaciones
    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Producto agregado correctamente.',
        ]);

    // Verificar que se creó en BD
    expect(Producto::where('nombre', 'Producto Test')->exists())->toBeTrue();
});
