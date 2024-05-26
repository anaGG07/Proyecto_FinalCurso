<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\GuestDataController;

// RUTA SIN AUTENTIFICAR
Route::get('/', [GuestDataController::class, 'store'])->name('start');
Route::post('/api/cookies', [GuestDataController::class, 'storeCookieDecision']);
Route::get('/inicio', function () {
    return Inertia::render('Inicio');
});


// RUTA AUTENTICADA
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Index');
    })->name('dashboard');
    Route::resource('guests',   GuestDataController::class);
    Route::get('/datos', [GuestDataController::class, 'index'])->name('datos');
});
