<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Lista de artículos (autorizado)']);
    }

    public function store(Request $request)
    {
        return response()->json(['message' => 'Artículo creado (autorizado)']);
    }

    public function update(Request $request, $id)
    {
        $articulo = Article::findOrFail($id);
        $user = auth()->user();

        // Ejemplo de validación manual:
        // Si no es admin Y no es el autor del artículo, le prohibimos editar
        if (!$user->hasRole('Admin') && $user->id !== $articulo->user_id) {
            return response()->json(['message' => 'No podés editar lo que no es tuyo'], 403);
        }

        $articulo->update($request->all());
        return response()->json(['message' => 'Articulo actualizado']);
    }

    public function destroy($id)
    {
        // Esta ruta ya viene protegida por el middleware 'role:Admin' en el archivo de rutas
        Article::destroy($id);
        return response()->json(['message' => 'Articulo borrado por el Administrador']);
    }
}
