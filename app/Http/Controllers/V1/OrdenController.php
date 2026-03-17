<?php

namespace App\Http\Controllers\v1;

use App\Services\OrdenService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdenController extends Controller
{
    protected OrdenService $service;

    public function __construct(OrdenService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAll(), 200);
    }

    public function show($id)
    {
        $orden = $this->service->getById($id);

        if (!$orden) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }

        return response()->json($orden, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'clientes_id' => 'required|exists:clientes,id',
            'total' => 'required|numeric',
            'estado' => 'required|string|max:20',
        ]);

        $orden = $this->service->create(
            $request->only(['clientes_id', 'total', 'estado'])
        );

        return response()->json([
            'message' => 'Orden creada correctamente',
            'data' => $orden
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'clientes_id' => 'required|exists:clientes,id',
            'total' => 'required|numeric',
            'estado' => 'required|string|max:20',
        ]);

        $orden = $this->service->update(
            $id,
            $request->only(['clientes_id', 'total', 'estado'])
        );

        if (!$orden) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }

        return response()->json([
            'message' => 'Orden actualizada correctamente',
            'data' => $orden
        ], 200);
    }

    public function destroy($id)
    {
        $deleted = $this->service->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }

        return response()->json([
            'message' => 'Orden eliminada correctamente'
        ], 200);
    }
}
