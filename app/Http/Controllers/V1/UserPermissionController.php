<?php

namespace App\Http\Controllers\V1;

use App\Services\UserPermissionService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserPermissionController extends Controller
{
    protected UserPermissionService $service;

    public function __construct(UserPermissionService $service)
    {
        $this->service = $service;
    }

    public function show($id)
    {
        $permissions = $this->service->getPermissionsByUser($id);
        return response()->json($permissions, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $permissions = $this->service->syncPermissionsToUser($id, $request->permissions);

        return response()->json([
            'message' => 'Permisos directos sincronizados correctamente en el usuario.',
            'data' => $permissions
        ], 200);
    }
}
