<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetodosPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $metodosPagos = ['tarjeta_credito', 'tarjeta_debito', 'transferencia', 'efectivo'];
        foreach ($metodosPagos as $metodoPago) {
            DB::table('metodos_pagos')->insert([
                'tipo' => $metodoPago,
            ]);
        }
    }
}
