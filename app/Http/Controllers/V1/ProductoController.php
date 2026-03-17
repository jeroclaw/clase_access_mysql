<?php

namespace App\Http\Controllers\V1;

use App\Services\ProductoService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    protected ProductoService $service;

    public function __construct(ProductoService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAll(), 200);
    }

    public function show($id)
    {
        $producto = $this->service->getById($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json($producto, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'disponible' => 'boolean',
        ]);

        $producto = $this->service->create(
            $request->only(['nombre', 'descripcion', 'precio', 'stock', 'disponible'])
        );

        return response()->json([
            'message' => 'Producto creado correctamente',
            'data' => $producto
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'disponible' => 'boolean',
        ]);

        $producto = $this->service->update(
            $id,
            $request->only(['nombre', 'descripcion', 'precio', 'stock', 'disponible'])
        );

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json([
            'message' => 'Producto actualizado correctamente',
            'data' => $producto
        ], 200);
    }

    public function destroy($id)
    {
        $deleted = $this->service->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json([
            'message' => 'Producto eliminado correctamente'
        ], 200);
    }
}
