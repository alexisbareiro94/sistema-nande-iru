<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {        
        Schema::create('planes_cuotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('venta_id')->constrained('ventas');
            $table->enum('tipo', ['mensual', 'semanal', 'quincenal', 'personalizado']);
            $table->integer('cantidad_cuotas');
            $table->integer('monto_total');
            $table->integer('saldo');
            $table->dateTime('fecha_inicio');
            $table->enum('estado', ['activo', 'completado', 'deudor'])->default('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_cuota');
        Schema::dropIfExists('planes_cuotas');
    }
};
