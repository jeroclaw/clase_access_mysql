<?php

namespace App\Http\Controllers\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(
                ['message' => 'Credenciales inválidas'], 401
            );
        }

        $user = Auth::user();
        $user->load('roles', 'permissions'); // carga roles en la misma respuesta

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => $user,              // user + roles + permisos juntos
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión cerrada']);
    }

    public function me(Request $request)
    {
        // Usado por Vue al recargar la página para rehidratar Pinia
        return response()->json(
            $request->user()->load('roles', 'permissions')
        );
    }
}

