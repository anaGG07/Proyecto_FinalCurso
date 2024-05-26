<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\GuestDataController;

// RUTAS SIN AUTENTIFICAR
Route::get('/', [GuestDataController::class, 'store'])->name('start');
Route::post('/api/cookies', [GuestDataController::class, 'storeCookieDecision']);
Route::post('/api/store-form', [GuestDataController::class, 'storeForm']);
Route::get('/inicio', function () {
    return Inertia::render('Inicio');
});

// RUTAS AUTENTICADAS
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Index');
    })->name('dashboard');
    Route::resource('guests', GuestDataController::class);
    Route::get('/datos', [GuestDataController::class, 'index'])->name('datos');
});


Route::get('/chart-data', [GuestDataController::class, 'getChartData']);


