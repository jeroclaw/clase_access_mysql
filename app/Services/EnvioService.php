<?php

namespace App\Services;

use App\Models\Envio;

class EnvioService
{
    public function getAll()
    {
        return Envio::with(['orden', 'cliente'])->get();
    }

    public function getById(int $id): ?Envio
    {
        return Envio::with(['orden', 'cliente'])->find($id);
    }
}
