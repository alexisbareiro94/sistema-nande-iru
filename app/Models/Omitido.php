<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Omitido extends Model
{
    protected $table = 'omitidos';

    protected $fillable = ['user_id'];

    public function users()
    {
        return $this->hasMany(User::class, 'user_id');
    }
}
