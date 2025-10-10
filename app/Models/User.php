<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;    
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'role',
        'razon_social',
        'telefono',
        'ruc_ci',
        'password',
        'salario',
        'activo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cajas(){
        return $this->hasMany(Caja::class, 'user_id');
    }

    public function notificaciones(){
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function ventas(){
        return $this->hasMany(Venta::class, 'vendedor_id');
    }

    public function pagoSalarios(){
        return $this->hasMany(PagoSalario::class, 'user_id');
    }
}
