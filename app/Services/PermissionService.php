<?php

namespace App\Services;

use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class PermissionService
{
    public function getAll()
    {
        return Permission::all();
    }

    public function getById($id)
    {
        return Permission::find($id);
    }

    public function create(array $data)
    {
        // Convierte "Ver Usuarios" en "ver_usuarios"
        $nameFormatted = Str::slug($data['name'], '_');

        return Permission::create([
            'name' => $nameFormatted,
            'guard_name' => 'web' // Forzar el guard para evitar conflictos
        ]);
    }

    public function update($id, array $data)
    {
        $permission = Permission::find($id);
        if ($permission) {
            // Convierte "Ver Usuarios" en "ver_usuarios"
            $nameFormatted = Str::slug($data['name'], '_');

            $permission->update(['name' => $nameFormatted]);
        }
        return $permission;
    }

    public function delete($id)
    {
        $permission = Permission::find($id);
        if ($permission) {
            return $permission->delete();
        }
        return false;
    }
}
