<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/clientes', function () {
    return \App\Models\Cliente::all();
});
