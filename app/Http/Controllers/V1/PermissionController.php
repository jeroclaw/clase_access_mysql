<?php

namespace App\Http\Controllers\V1;

use App\Services\PermissionService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected PermissionService $service;

    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAll(), 200);
    }

    public function show($id)
    {
        $permission = $this->service->getById($id);
        if (!$permission) return response()->json(['message' => 'Permiso no encontrado'], 404);
        return response()->json($permission, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);

        $permission = $this->service->create($request->all());

        return response()->json([
            'message' => 'Permiso creado correctamente',
            'data' => $permission
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $id,
        ]);

        $permission = $this->service->update($id, $request->all());

        if (!$permission) return response()->json(['message' => 'Permiso no encontrado'], 404);

        return response()->json([
            'message' => 'Permiso actualizado correctamente',
            'data' => $permission
        ], 200);
    }

    public function destroy($id)
    {
        $deleted = $this->service->delete($id);
        if (!$deleted) return response()->json(['message' => 'Permiso no encontrado'], 404);

        return response()->json([
            'message' => 'Permiso eliminado correctamente'
        ], 200);
    }
}
