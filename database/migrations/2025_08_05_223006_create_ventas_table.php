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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caja_id')->constrained('users');
            $table->foreignId('cliente_id')->constrained('users');
            $table->boolean('venta_con_descuento')->default(false);
            $table->integer('monto_descuento')->nullable();
            $table->integer('subtotal');
            $table->integer('total');
            $table->enum('estado', ['pendiente', 'completado', 'cancelado'])->default('pendiente')->index();
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
