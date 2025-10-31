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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();            
            $table->foreignId('tenant_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->enum('role', ['admin', 'caja', 'user', 'personal','cliente'])->default('cliente'); 
            $table->string('razon_social')->nullable();
            $table->string('ruc_ci')->nullable()->unique();
            $table->integer('telefono')->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('temp_password')->nullable();
            $table->integer('salario')->nullable();
            $table->boolean('activo')->nullable();
            $table->boolean('en_linea')->nullable();            
            $table->dateTimeTz('ultima_conexion')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('temp_used')->nullable()->default(false);
            $table->boolean('is_blocked')->nullable()->default(false);
            $table->string('empresa')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
