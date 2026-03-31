<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ordene extends Model
{
    protected $fillable = [
        'clientes_id',
        'total',
        'envio',
    ];

    protected $casts = [
        'envio' => 'boolean',
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

    public function detalles()
    {
        return $this->hasMany(DetalleOrden::class, 'ordene_id');
    }

    public function envio()
    {
        return $this->hasOne(Envio::class, 'ordene_id');
    }

}
