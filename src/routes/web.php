<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\ZonaController;

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
