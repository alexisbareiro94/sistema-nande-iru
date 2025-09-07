<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\TipoCuotaSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\DB;
use App\Models\Caja;
use App\Models\Venta;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $this->call([
      UserSeeder::class,
    ]);

    Caja::factory()
      ->has(Venta::factory()->count(20))
      ->create();


    DB::table('marcas')->insert([
      'nombre' => 'sin marca'
    ]);

    DB::table('categorias')->insert([
      'nombre' => 'sin categoria',
    ]);

    DB::table('distribuidores')->insert([
      'nombre' => 'sin distribuidor'
    ]);

    \App\Models\Producto::factory(50)->create();
  }
}
