<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EspacioController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EspacioController as AdminEspacioController;
use App\Http\Controllers\Admin\ReservaController as AdminReservaController;
use App\Http\Controllers\Admin\TipoEspacioController;
use App\Http\Controllers\Admin\ComodidadController;

// =====================
// ZONA PÚBLICA
// =====================
Route::get('/', [EspacioController::class, 'index'])->name('inicio');
Route::get('/espacios/{espacio}', [EspacioController::class, 'show'])->name('espacios.show');

// Autenticación (Breeze)
require __DIR__.'/auth.php';

// =====================
// ZONA USUARIO (miembro)
// =====================
Route::middleware(['auth', 'role:member'])->group(function () {
    // Ver disponibilidad de un espacio (POST para recibir fecha)
    Route::post('/espacios/{espacio}/disponibilidad', [ReservaController::class, 'disponibilidad'])
        ->name('espacios.disponibilidad');

    // Crear reserva
    Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');

    // Mis reservas
    Route::get('/mis-reservas', [ReservaController::class, 'misReservas'])->name('reservas.mis');

    // Cancelar reserva (dueño)
    Route::delete('/reservas/{reserva}', [ReservaController::class, 'cancelar'])->name('reservas.cancelar');
});

// =====================
// ZONA ADMINISTRACIÓN
// =====================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/panel', [DashboardController::class, 'index'])->name('panel');

    // CRUD Tipos de espacio
    Route::resource('tipos-espacio', TipoEspacioController::class)->parameters([
        'tipos-espacio' => 'tipoEspacio'
    ]);

    // CRUD Espacios
    Route::resource('espacios', AdminEspacioController::class)->parameters([
        'espacios' => 'espacio'
    ]);

    // CRUD Comodidades (asociadas a un espacio)
    Route::resource('espacios.comodidades', ComodidadController::class)->parameters([
        'espacios' => 'espacio',
        'comodidades' => 'comodidad'
    ])->shallow();

    // Reservas del día
    Route::get('/reservas/hoy', [AdminReservaController::class, 'hoy'])->name('reservas.hoy');

    // Confirmar/cancelar cualquier reserva
    Route::post('/reservas/{reserva}/confirmar', [AdminReservaController::class, 'confirmar'])
        ->name('reservas.confirmar');
    Route::post('/reservas/{reserva}/cancelar', [AdminReservaController::class, 'cancelar'])
        ->name('reservas.cancelar');

    // Ocupación general
    Route::get('/ocupacion', [AdminReservaController::class, 'ocupacion'])->name('ocupacion');

    // (Extra) Calendario semanal
    Route::get('/calendario/{espacio}', [AdminReservaController::class, 'calendario'])->name('calendario');
});