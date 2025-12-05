<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistroController;

Route::get('/', function () {
    return view('welcome');
});

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