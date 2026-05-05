<?php

namespace App\Services;

use App\Models\User;

class UserRoleService
{
    public function getRolesByUser($userId)
    {
        $user = User::findOrFail($userId);
        return $user->roles;
    }

    public function syncRolesToUser($userId, array $roles)
    {
        $user = User::findOrFail($userId);
        // Sincroniza (reemplaza) los roles directos del usuario
        $user->syncRoles($roles);
        return $user->roles;
    }
}
