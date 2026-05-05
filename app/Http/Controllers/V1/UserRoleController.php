<?php

namespace App\Http\Controllers\V1;

use App\Services\UserRoleService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    protected UserRoleService $service;

    public function __construct(UserRoleService $service)
    {
        $this->service = $service;
    }

    public function show($id)
    {
        $roles = $this->service->getRolesByUser($id);
        return response()->json($roles, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        $roles = $this->service->syncRolesToUser($id, $request->roles);

        return response()->json([
            'message' => 'Roles sincronizados correctamente con el usuario.',
            'data' => $roles
        ], 200);
    }
}
