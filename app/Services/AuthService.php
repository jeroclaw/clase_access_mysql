<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;

class AuthService
{
    public function login(array $credentials)
    {
        $user = User::where('email', $credentials['email'])->first();

        // Verificamos si el usuario no existe o si la clave no concuerda
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new Exception('Credenciales incorrectas');
        }

        // Creamos el Token de acceso con Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        // Obtenemos los roles y todos los permisos (heredados y directos) vía Spatie
        $roles = $user->getRoleNames();
        $permissions = $user->getAllPermissions()->pluck('name');

        return [
            'user' => $user,
            'token' => $token,
            'roles' => $roles,
            'permissions' => $permissions,
        ];
    }
}
