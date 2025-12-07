<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\ZonaController;
use App\Http\Controllers\TipoReservaController;
use App\Http\Controllers\VehiculoController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');

Route::get('/registro', [RegistroController::class, 'index'])->name('registro.index');
Route::post('/registro/seleccionar', [RegistroController::class, 'seleccionar'])->name('registro.seleccionar');

Route::get('/registro/viajero', [RegistroController::class, 'registroViajero'])->name('registro.viajero');
Route::post('/registro/viajero', [RegistroController::class, 'storeViajero'])->name('registro.viajero.store');

Route::get('/registro/hotel', [RegistroController::class, 'registroHotel'])->name('registro.hotel');
Route::post('/registro/hotel', [RegistroController::class, 'storeHotel'])->name('registro.hotel.store');

Route::get('/registro/admin', [RegistroController::class, 'registroAdmin'])->name('registro.admin');
Route::post('/registro/admin', [RegistroController::class, 'storeAdmin'])->name('registro.admin.store');

Route::get('/zona', [ZonaController::class, 'index'])->name('zona.index');
Route::get('/zona/create', [ZonaController::class, 'create'])->name('zona.create');
Route::post('/zona/create', [ZonaController::class, 'store'])->name('zona.store');
Route::get('/zona/{id}/edit', [ZonaController::class, 'edit'])->name('zona.edit');
Route::post('/zona{id}/edit', [ZonaController::class, 'update'])->name('zona.update');
Route::delete('/zona/{id}', [ZonaController::class, 'destroy'])->name('zona.destroy');

Route::get('/reservatipo', [TipoReservaController::class, 'index'])->name('reservatipo.index');
Route::get('/reservatipo/create', [TipoReservaController::class, 'create'])->name('reservatipo.create');
Route::post('/reservatipo', [TipoReservaController::class, 'store'])->name('reservatipo.store');
Route::get('/reservatipo/{id}/edit', [TipoReservaController::class, 'edit'])->name('reservatipo.edit');
Route::post('/reservatipo{id}/edit', [TipoReservaController::class, 'update'])->name('reservatipo.update');
Route::delete('/reservatipo/{id}', [TipoReservaController::class, 'destroy'])->name('reservatipo.destroy');

Route::get('/vehiculo', [VehiculoController::class, 'index'])->name('vehiculo.index');
Route::get('/vehiculo/create', [VehiculoController::class, 'create'])->name('vehiculo.create');
Route::post('/vehiculo', [VehiculoController::class, 'store'])->name('vehiculo.store');
Route::get('/vehiculo/{id}/edit', [VehiculoController::class, 'edit'])->name('vehiculo.edit');
Route::put('/vehiculo/{id}', [VehiculoController::class, 'update'])->name('vehiculo.update');
Route::delete('/vehiculo/{id}', [VehiculoController::class, 'destroy'])->name('vehiculo.destroy');