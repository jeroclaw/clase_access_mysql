<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleOrden extends Model
{
    protected $table = 'detalle_ordenes';

    protected $fillable = [
        'ordene_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
    ];

    public function orden()
    {
        return $this->belongsTo(Ordene::class, 'ordene_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
