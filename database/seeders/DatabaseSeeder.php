<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\TipoCuotaSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;
use App\Models\Caja;
use App\Models\MovimientoCaja;
use App\Models\Venta;
use Database\Factories\VentaFactory;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // $this->call([
    //   UserSeeder::class,
    // ]);

    // DB::table('marcas')->insert([
    //   'nombre' => 'sin marca'
    // ]);

    // DB::table('categorias')->insert([
    //   'nombre' => 'sin categoria',
    // ]);

    // DB::table('distribuidores')->insert([
    //   'nombre' => 'sin distribuidor'
    // ]);

    // \App\Models\Producto::factory(50)->create();
    
    // User::factory(11)->create();    
    // Venta::factory(79)->create([
    //   'cliente_id' => User::all()->random()->id,
    //   'total' => 2000000,
    // ]);

    MovimientoCaja::factory(12)->create();
    
  }
}
