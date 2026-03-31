<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\ClienteController;
use App\Http\Controllers\V1\OrdenController;
use App\Http\Controllers\V1\ProductoController;
use App\Http\Controllers\V1\DetalleOrdenController;
use App\Http\Controllers\V1\EnvioController;

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
