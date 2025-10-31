<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->tenant_id && auth()->check()) {
                $model->tenant_id = auth()->user()->role === 'admin'
                    ? auth()->user()->id
                    : auth()->user()->tenant_id;
            }
        });
    }

    protected $fillable = [
        'name',
        'email',
        'role',
        'razon_social',
        'telefono',
        'ruc_ci',
        'password',
        'salario',
        'activo',
        'ultima_conexion',
        'en_linea',
        'tenant_id',
        'temp_password',
        'expires_at',
        'temp_used',
        'is_blocked',
        'empresa',
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

    public function cajas()
    {
        return $this->hasMany(Caja::class, 'user_id');
    }

    public function notificaciones()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'vendedor_id');
    }
    public function ultima_venta()
    {
        return $this->hasOne(Venta::class, 'vendedor_id')->latest('created_at');
    }

    public function pagoSalarios()
    {
        return $this->hasMany(PagoSalario::class, 'user_id');
    }

    public function auditorias()
    {
        return $this->hasMany(Auditoria::class);
    }

    public function compras()
    {
        return $this->hasMany(Venta::class, 'cliente_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }
}
