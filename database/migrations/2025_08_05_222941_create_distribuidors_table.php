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
        Schema::create('distribuidores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nombre')->unique();
            $table->string('ruc')->nullable()->unique();
            $table->integer('celular')->nullable();
            $table->string('direccion')->nullable();
            $table->timestamps();
        });

        Schema::create('vendedores_dist', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('distribuidor_id')->constrained('distribuidores');
            $table->string('nombre');
            $table->string('telefono')->nullable();
            $table->integer('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribuidors');
    }
};
