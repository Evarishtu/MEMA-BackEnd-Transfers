<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Api\ZonaStatsController;

    Route::get('/reservas/zonas', [ZonaStatsController::class, 'reservasPorZona']);
?>