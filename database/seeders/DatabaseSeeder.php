<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\TipoCuotaSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $this->call([
      MetodosPagoSeeder::class,
      TipoCuotaSeeder::class,
      UserSeeder::class,
    ]);

    DB::table('marcas')->insert([      
      'nombre' => 'sin marca'
    ]);

    DB::table('categorias')->insert([
      'nombre' => 'sin categoria',
    ]);

    DB::table('distribuidores')->insert([
      'nombre' => 'sin distribuidor'
    ]);
  }
}
