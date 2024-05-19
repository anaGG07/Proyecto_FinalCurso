<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProjectController;

// (autentificada)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
// RUTA DE EJEMPLO
    Route::get('/prueba', function () {
        return Inertia::render('Prueba');
    })->name('prueba');


    Route::get('/pruebaAna', function () {
        return Inertia::render('PruebaAna');
    })->name('pruebaAna');


    Route::get('/dashboard', function () {
        return Inertia::render('Index');
    })->name('dashboard');
});


// RUTA SIN AUTENTIFICAR
Route::get('/', function () {
    return Inertia::render('Welcome', [
        //'canLogin' => Route::has('login'),
   //     'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});




// RUTA DE EJEMPLO SIN AUTENTIFICAR
Route::get('/inicio', function () {
    return Inertia::render('Inicio');
});


// CRUD
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // ...

    Route::resource('projects', ProjectController::class);
});
