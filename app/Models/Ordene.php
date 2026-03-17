<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ordene extends Model
{
    protected $fillable = [
        'clientes_id',
        'total',
        'estado',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'clientes_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'detalle_ordenes')
            ->withPivot('cantidad', 'precio_unitario')
            ->withTimestamps();
    }

}
