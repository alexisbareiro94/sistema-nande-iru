<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoCuotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = ['mensual', 'semanal', 'quincenal', 'personalizado'];
        foreach ($tipos as $tipo) {
            DB::table('tipos_cuota')->insert([
                'tipo' => $tipo,
            ]);
        }
    }
}
