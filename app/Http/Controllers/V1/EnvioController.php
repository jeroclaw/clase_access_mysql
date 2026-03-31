<?php

namespace App\Http\Controllers\V1;

use App\Services\EnvioService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EnvioController extends Controller
{
    protected EnvioService $service;

    public function __construct(EnvioService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAll(), 200);
    }

    public function show($id)
    {
        $envio = $this->service->getById($id);

        if (!$envio) {
            return response()->json(['message' => 'Envío no encontrado'], 404);
        }

        return response()->json($envio, 200);
    }
}
