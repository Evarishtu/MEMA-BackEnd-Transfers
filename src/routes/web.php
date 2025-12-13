<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\ZonaController;
use App\Http\Controllers\TipoReservaController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ViajeroController;

Route::get('/', function () {
    return view('home');
})->name('home');

//LOGIN ROUTES
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');


//REGISTOS
Route::get('/registro', [RegistroController::class, 'index'])->name('registro.index');
Route::post('/registro/seleccionar', [RegistroController::class, 'seleccionar'])->name('registro.seleccionar');

//REG - VIAJERO
Route::get('/registro/viajero', [RegistroController::class, 'registroViajero'])->name('registro.viajero');
Route::post('/registro/viajero', [RegistroController::class, 'storeViajero'])->name('registro.viajero.store');
Route::prefix('viajero')->middleware('auth:viajero')->group(function () {
    Route::get('/dashboard', [ViajeroController::class, 'dashboard'])->name('viajero.dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('viajero.logout');
    // INFORMACIÓN PERSONAL
    Route::get('/info', [ViajeroController::class, 'informacionPersonal'])->name('viajero.info');
    Route::put('/info', [ViajeroController::class, 'actualizarInformacionPersonal'])->name('viajero.info.update');
    // RESERVAS
    Route::get('/reservas', [ViajeroController::class, 'listarReservas'])->name('viajero.listar');
    Route::get('/datos', [ViajeroController::class, 'crearReserva'])->name('viajero.datos');
    Route::post('/reservas', [ViajeroController::class, 'guardarReserva'])->name('viajero.reservas.store');
    Route::get('/reservas/{id}', [ViajeroController::class, 'verReserva'])->name('viajero.reservas.ver');
    Route::delete('/reservas/{id}', [ViajeroController::class, 'cancelarReserva'])->name('viajero.cancelar');
    Route::get('/reservas/confirmacion/{localizador}',[ViajeroController::class, 'confirmacionReserva'])->name('viajero.confirmacion');
});

//REG - HOTEL
Route::get('/registro/hotel', [RegistroController::class, 'registroHotel'])->name('registro.hotel');
Route::post('/registro/hotel', [RegistroController::class, 'storeHotel'])->name('registro.hotel.store');

//REG - ADMIN
Route::get('/registro/admin', [RegistroController::class, 'registroAdmin'])->name('registro.admin');
Route::post('/registro/admin', [RegistroController::class, 'storeAdmin'])->name('registro.admin.store');
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    //DASHBOARD
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    //LOGOUT
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    //INFO PERSONAL
    Route::get('/info', [AdminController::class, 'informacionPersonal'])->name('admin.info');                
    Route::put('/info', [AdminController::class, 'actualizarInformacionPersonal'])->name('admin.info.update');
    //CREAR RESERVA – Paso 1
    Route::get('/reservas/crear', [AdminController::class, 'crearReserva'])->name('admin.reservas.crear');
    //CREAR RESERVA – Paso 2
    Route::match(['GET', 'POST'], '/reservas/datos', [AdminController::class, 'crearReservaDatos'])->name('admin.reservas.datos');
    //CREAR RESERVA – Paso 3 (guardar)
    Route::post('/reservas/guardar', [AdminController::class, 'guardarReserva'])->name('admin.reservas.guardar');
    Route::get('/reservas/confirmacion', [AdminController::class, 'confirmacionReserva'])->name('admin.reservas.confirmacion');
    //CREAR VIAJERO DESDE ADMIN
    Route::post('/viajero/registrar', [AdminController::class, 'registrarViajeroDesdeAdmin'])->name('admin.viajero.store');
    //LISTADO RESERVAS
    Route::get('/reservas', [AdminController::class, 'listarReservas'])->name('admin.reservas.index');
    Route::get('/reservas/{id}', [AdminController::class, 'verReserva'])->name('admin.reservas.ver');
    Route::get('/reservas/{id}/editar', [AdminController::class, 'editarReserva'])->name('admin.reservas.editar');
    Route::put('/reservas/{id}', [AdminController::class, 'actualizarReserva'])->name('admin.reservas.actualizar');
    Route::delete('/reservas/{id}', [AdminController::class, 'cancelarReserva'])->name('admin.reservas.cancelar');
    //CALENDARIO
    Route::get('/calendario', [AdminController::class, 'calendario'])->name('admin.calendario');
    //ALTA HOTEL
    Route::get('/hoteles/crear', [HotelController::class, 'createCorporativo'])->name('admin.hotel.crear');
    Route::post('/hoteles', [HotelController::class, 'store'])->name('admin.hotel.store');
    //COMISIONES HOTEL
    Route::get('/comisiones', [AdminController::class, 'comisionesHoteles'])->name('admin.comisiones');
});

//HOTEL
Route::get('/hotel', [HotelController::class, 'index'])->name('hotel.index');
Route::get('/hotel/create', [HotelController::class, 'create'])->name('hotel.create');
Route::post('/hotel', [HotelController::class, 'store'])->name('hotel.store');
Route::get('/hotel/{id}/edit', [HotelController::class, 'edit'])->name('hotel.edit');
Route::put('/hotel/{id}', [HotelController::class, 'update'])->name('hotel.update');
Route::delete('/hotel/{id}', [HotelController::class, 'destroy'])->name('hotel.destroy');


//ZONAS
Route::get('/zona', [ZonaController::class, 'index'])->name('zona.index');
Route::get('/zona/create', [ZonaController::class, 'create'])->name('zona.create');
Route::post('/zona/create', [ZonaController::class, 'store'])->name('zona.store');
Route::get('/zona/{id}/edit', [ZonaController::class, 'edit'])->name('zona.edit');
Route::post('/zona{id}/edit', [ZonaController::class, 'update'])->name('zona.update');
Route::delete('/zona/{id}', [ZonaController::class, 'destroy'])->name('zona.destroy');

//TIPO RESERVA
Route::get('/reservatipo', [TipoReservaController::class, 'index'])->name('reservatipo.index');
Route::get('/reservatipo/create', [TipoReservaController::class, 'create'])->name('reservatipo.create');
Route::post('/reservatipo', [TipoReservaController::class, 'store'])->name('reservatipo.store');
Route::get('/reservatipo/{id}/edit', [TipoReservaController::class, 'edit'])->name('reservatipo.edit');
Route::put('/reservatipo/{id}', [TipoReservaController::class, 'update'])->name('reservatipo.update');
Route::delete('/reservatipo/{id}', [TipoReservaController::class, 'destroy'])->name('reservatipo.destroy');

//VEHÍCULOS
Route::get('/vehiculo', [VehiculoController::class, 'index'])->name('vehiculo.index');
Route::get('/vehiculo/create', [VehiculoController::class, 'create'])->name('vehiculo.create');
Route::post('/vehiculo/store', [VehiculoController::class, 'store'])->name('vehiculo.store');
Route::get('/vehiculo/{id}/edit', [VehiculoController::class, 'edit'])->name('vehiculo.edit');
Route::put('/vehiculo/{id}', [VehiculoController::class, 'update'])->name('vehiculo.update');
Route::delete('/vehiculo/{id}', [VehiculoController::class, 'destroy'])->name('vehiculo.destroy');
