<?php

namespace App\Services;

use Spatie\Permission\Models\Role;

class RoleService
{
    public function getAll()
    {
        return Role::with('permissions')->get();
    }

    public function getById($id)
    {
        return Role::with('permissions')->find($id);
    }

    public function create(array $data)
    {
        $role = Role::create([
            'name' => $data['name'],
            'guard_name' => 'web' // Forzar el guard para evitar conflictos
        ]);

        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        return $role->load('permissions');
    }

    public function update($id, array $data)
    {
        $role = Role::find($id);
        if (!$role) return null;

        if (isset($data['name'])) {
            $role->update(['name' => $data['name']]);
        }

        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        return $role->load('permissions');
    }

    public function delete($id)
    {
        $role = Role::find($id);
        if ($role) {
            return $role->delete();
        }
        return false;
    }
}
