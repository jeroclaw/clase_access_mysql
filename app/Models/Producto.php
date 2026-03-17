<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'disponible',
    ];
    // Relaciones
    public function ordenes()
    {
        return $this->belongsToMany(Ordene::class, 'detalle_ordenes')
            ->withPivot('cantidad', 'precio_unitario')
            ->withTimestamps();
    }

}
