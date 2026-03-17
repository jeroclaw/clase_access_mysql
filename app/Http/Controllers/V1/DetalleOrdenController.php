<?php

namespace App\Http\Controllers\V1;

use App\Services\DetalleOrdenService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DetalleOrdenController extends Controller
{
    protected DetalleOrdenService $service;

    public function __construct(DetalleOrdenService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAll(), 200);
    }

    public function show($id)
    {
        $detalle = $this->service->getById($id);

        if (!$detalle) {
            return response()->json(['message' => 'Detalle no encontrado'], 404);
        }

        return response()->json($detalle, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'ordene_id' => 'required|exists:ordenes,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer',
            'precio_unitario' => 'required|numeric',
        ]);

        $detalle = $this->service->create(
            $request->only(['ordene_id', 'producto_id', 'cantidad', 'precio_unitario'])
        );

        return response()->json([
            'message' => 'Detalle creado correctamente',
            'data' => $detalle
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ordene_id' => 'required|exists:ordenes,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer',
            'precio_unitario' => 'required|numeric',
        ]);

        $detalle = $this->service->update(
            $id,
            $request->only(['ordene_id', 'producto_id', 'cantidad', 'precio_unitario'])
        );

        if (!$detalle) {
            return response()->json(['message' => 'Detalle no encontrado'], 404);
        }

        return response()->json([
            'message' => 'Detalle actualizado correctamente',
            'data' => $detalle
        ], 200);
    }

    public function destroy($id)
    {
        $deleted = $this->service->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Detalle no encontrado'], 404);
        }

        return response()->json([
            'message' => 'Detalle eliminado correctamente'
        ], 200);
    }
}
