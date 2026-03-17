<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'name',
        'email',
    ];

    public function ordenes()
    {
        return $this->hasMany(Ordene::class, 'clientes_id');
    }
}
