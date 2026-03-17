<?php

namespace App\Http\Controllers\V1;

use App\Services\ClienteService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    protected ClienteService $service;

    public function __construct(ClienteService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAll(), 200);
    }

    public function show($id)
    {
        $cliente = $this->service->getById($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        return response()->json($cliente, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clientes,email',
        ]);

        $cliente = $this->service->create(
            $request->only(['name', 'email'])
        );

        return response()->json([
            'message' => 'Cliente creado correctamente',
            'data' => $cliente
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clientes,email,' . $id,
        ]);

        $cliente = $this->service->update(
            $id,
            $request->only(['name', 'email'])
        );

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        return response()->json([
            'message' => 'Cliente actualizado correctamente',
            'data' => $cliente
        ], 200);
    }

    public function destroy($id)
    {
        $deleted = $this->service->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        return response()->json([
            'message' => 'Cliente eliminado correctamente'
        ], 200);
    }
}
