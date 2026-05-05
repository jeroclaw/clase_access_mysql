<?php

namespace App\Http\Controllers\V1;

use App\Services\RoleService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected RoleService $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAll(), 200);
    }

    public function show($id)
    {
        $role = $this->service->getById($id);
        if (!$role) return response()->json(['message' => 'Rol no encontrado'], 404);
        return response()->json($role, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $role = $this->service->create($request->all());

        return response()->json([
            'message' => 'Rol creado correctamente',
            'data' => $role
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string|unique:roles,name,' . $id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $role = $this->service->update($id, $request->all());

        if (!$role) return response()->json(['message' => 'Rol no encontrado'], 404);

        return response()->json([
            'message' => 'Rol actualizado correctamente',
            'data' => $role
        ], 200);
    }

    public function destroy($id)
    {
        $deleted = $this->service->delete($id);
        if (!$deleted) return response()->json(['message' => 'Rol no encontrado'], 404);

        return response()->json(['message' => 'Rol eliminado correctamente'], 200);
    }
}
