<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\ClienteController;
use App\Http\Controllers\V1\OrdenController;
use App\Http\Controllers\V1\ProductoController;
use App\Http\Controllers\V1\DetalleOrdenController;
use App\Http\Controllers\V1\EnvioController;
use App\Http\Controllers\V1\UserController;
use App\Http\Controllers\V1\RoleController;
use App\Http\Controllers\V1\PermissionController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\V1\RolePermissionController;
use App\Http\Controllers\V1\UserRoleController;
use App\Http\Controllers\V1\UserPermissionController;

// CLIENTES
Route::get('/clientes', [ClienteController::class, 'index']);
Route::post('/clientes', [ClienteController::class, 'store']);
Route::get('/clientes/{id}', [ClienteController::class, 'show']);
Route::put('/clientes/{id}', [ClienteController::class, 'update']);
Route::delete('/clientes/{id}', [ClienteController::class, 'destroy']);

// ORDENES
Route::get('/ordenes', [OrdenController::class, 'index']);
Route::post('/ordenes', [OrdenController::class, 'store']);
Route::get('/ordenes/{id}', [OrdenController::class, 'show']);
Route::put('/ordenes/{id}', [OrdenController::class, 'update']);
Route::delete('/ordenes/{id}', [OrdenController::class, 'destroy']);

// PRODUCTOS
Route::get('/productos', [ProductoController::class, 'index']);
Route::post('/productos', [ProductoController::class, 'store']);
Route::get('/productos/{id}', [ProductoController::class, 'show']);
Route::put('/productos/{id}', [ProductoController::class, 'update']);
Route::delete('/productos/{id}', [ProductoController::class, 'destroy']);

// DETALLE ORDENES
Route::get('/detalle-ordenes', [DetalleOrdenController::class, 'index']);
Route::post('/detalle-ordenes', [DetalleOrdenController::class, 'store']);
Route::get('/detalle-ordenes/{id}', [DetalleOrdenController::class, 'show']);
Route::put('/detalle-ordenes/{id}', [DetalleOrdenController::class, 'update']);
Route::delete('/detalle-ordenes/{id}', [DetalleOrdenController::class, 'destroy']);

// ENVIOS
Route::get('/envios', [EnvioController::class, 'index']);
Route::get('/envios/{id}', [EnvioController::class, 'show']);

// AUTENTICACIÓN
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // SEGURIDAD (Usuarios, Roles y Permisos)
    Route::apiResource('/users', UserController::class);
    Route::apiResource('/roles', RoleController::class);
    Route::apiResource('/permissions', PermissionController::class);

    // RELACIONES ROLES - PERMISOS
    Route::get('/roles/{id}/permissions', [RolePermissionController::class, 'show']);
    Route::post('/roles/{id}/sync-permisos', [RolePermissionController::class, 'update']);

    // RELACIONES USUARIOS - ROLES
    Route::get('/users/{id}/roles', [UserRoleController::class, 'show']);
    Route::post('/users/{id}/sync-roles', [UserRoleController::class, 'update']);

    // RELACIONES USUARIOS - PERMISOS DIRECTOS
    Route::get('/users/{id}/permissions', [UserPermissionController::class, 'show']);
    Route::put('/users/{id}/permissions', [UserPermissionController::class, 'update']);

    // Todos los autenticados pueden ver la lista
    Route::get('/articulos', [ArticleController::class, 'index']);

    // Solo los que tienen permiso de crear
    Route::post('/articulos', [ArticleController::class, 'store'])
         ->middleware('permission:crear articulos');

    // Solo los que tienen permiso de editar (Nota que aquí sí pasamos un {id})
    Route::put('/articulos/{id}', [ArticleController::class, 'update'])
         ->middleware('permission:editar articulos');

    // Solo el Admin puede borrar (protección por ROL)
    Route::delete('/articulos/{id}', [ArticleController::class, 'destroy'])
         ->middleware('role:Admin');
});
