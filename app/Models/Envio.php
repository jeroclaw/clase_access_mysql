<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Envio extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ordene_id',
        'cliente_id',
        'fecha_envio',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_envio' => 'datetime',
    ];

    /**
     * Get the order that owns the shipment.
     */
    public function orden(): BelongsTo
    {
        return $this->belongsTo(Ordene::class, 'ordene_id');
    }

    /**
     * Get the client that owns the shipment.
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
