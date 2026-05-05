<?php

namespace App\Services;

use App\Models\User;

class UserPermissionService
{
    public function getPermissionsByUser($userId)
    {
        $user = User::findOrFail($userId);
        // getAllPermissions() retorna los combinados: (Directos + Por Roles)
        return $user->getAllPermissions();
    }

    public function syncPermissionsToUser($userId, array $permissions)
    {
        $user = User::findOrFail($userId);

        // syncPermissions sólo reemplaza los permisos DIRECTOS del usuario
        $user->syncPermissions($permissions);

        return $user->getAllPermissions();
    }
}
