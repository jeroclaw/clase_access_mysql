<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    // Habilitamos la asignación masiva
    protected $fillable = ['title', 'content', 'user_id'];

    // Relación: Un artículo le pertenece a un Usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
