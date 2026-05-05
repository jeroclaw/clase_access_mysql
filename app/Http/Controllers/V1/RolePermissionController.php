<?php

namespace App\Http\Controllers\V1;

use App\Services\RolePermissionService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RolePermissionController extends Controller
{
    protected RolePermissionService $service;

    public function __construct(RolePermissionService $service)
    {
        $this->service = $service;
    }

    public function show($id)
    {
        $permissions = $this->service->getPermissionsByRole($id);
        return response()->json($permissions, 200);
    }

    public function update(Request $request, $id)
    {
        // Formateamos los permisos ("Ver Usuarios" a "ver_usuarios") antes de validar
        if ($request->has('permissions') && is_array($request->permissions)) {
            $formattedPermissions = array_map(function ($perm) {
                return is_string($perm) ? Str::slug($perm, '_') : $perm;
            }, $request->permissions);

            $request->merge(['permissions' => $formattedPermissions]);
        }

        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $permissions = $this->service->syncPermissionsToRole($id, $request->permissions);

        return response()->json([
            'message' => 'Permisos sincronizados correctamente con el rol.',
            'data' => $permissions
        ], 200);
    }
}
