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
            $table->foreignId('user_id')->constrained('users'); //cajero responsable
            $table->integer('monto_inicial');
            $table->integer('monto_cierre')->nullable();
            $table->enum('estado', ['abierto', 'cerrado'])->unique();
            $table->integer('diferencia')->nullable();
            $table->dateTimeTz('fecha_apertura');
            $table->dateTimeTz('fecha_cierre')->nullable();
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
