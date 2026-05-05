<?php

namespace App\Services;

use Spatie\Permission\Models\Role;

class RolePermissionService
{
    public function getPermissionsByRole($roleId)
    {
        $role = Role::findOrFail($roleId);
        return $role->permissions;
    }

    public function syncPermissionsToRole($roleId, array $permissions)
    {
        $role = Role::findOrFail($roleId);
        // Sincroniza (reemplaza) los permisos actuales con el array proporcionado
        $role->syncPermissions($permissions);
        return $role->permissions;
    }
}
