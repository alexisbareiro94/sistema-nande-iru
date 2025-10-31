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

        Schema::create('cajas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users'); // cajero que abrió
            $table->integer('monto_inicial');
            $table->integer('monto_cierre')->nullable(); // monto contado
            $table->integer('saldo_esperado')->nullable(); // calculado por sistema
            $table->integer('diferencia')->nullable();
            $table->integer('egresos')->nullable();
            $table->text('observaciones')->nullable();
            $table->dateTime('fecha_apertura');
            $table->dateTime('fecha_cierre')->nullable(); // cuando se cerró
            $table->enum('estado', ['abierto', 'cerrado'])->default('abierta');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cajas');
    }
};
