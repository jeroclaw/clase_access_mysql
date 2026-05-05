<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAll()
    {
        return User::with(['roles', 'permissions'])->get();
    }

    public function getById($id)
    {
        return User::with(['roles', 'permissions'])->find($id);
    }

    public function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }
        if (isset($data['permissions'])) {
            $user->syncPermissions($data['permissions']);
        }

        return $user->load('roles', 'permissions');
    }

    public function update($id, array $data)
    {
        $user = User::find($id);
        if (!$user) return null;

        $user->update(array_filter([
            'name' => $data['name'] ?? null,
            'email' => $data['email'] ?? null,
            'password' => isset($data['password']) ? Hash::make($data['password']) : null,
        ]));

        if (isset($data['roles'])) { $user->syncRoles($data['roles']); }
        if (isset($data['permissions'])) { $user->syncPermissions($data['permissions']); }

        return $user->load('roles', 'permissions');
    }

    public function delete($id)
    {
        $user = User::find($id);
        return $user ? $user->delete() : false;
    }
}
