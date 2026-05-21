<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Estudiante\DashboardController as EstudianteDashboardController;

Route::get('/', function () {
    // If the user is already authenticated, redirect them to their dashboard
    if (Auth::check()) {
        $roleRoutes = [
            1 => '/admin/dashboard',
            2 => '/coordinador/dashboard',
            3 => '/estudiante/dashboard',
            4 => '/empresa/dashboard',
        ];
        return redirect($roleRoutes[Auth::user()->rol_id] ?? '/');
    }
    return view('welcome');
})->name('login');

// Authentication routes
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Protected dashboard routes
Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('/admin/dashboard', function () {
        if (Auth::user()->rol_id != 1) return redirect('/');
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/config', function () {
        if (Auth::user()->rol_id != 1) return redirect('/');
        return view('admin.config');
    })->name('admin.config');

    Route::get('/admin/usuarios', function () {
        if (Auth::user()->rol_id != 1) return redirect('/');
        return view('admin.usuarios');
    })->name('admin.usuarios');

    Route::get('/coordinador/dashboard', function () {
        if (Auth::user()->rol_id != 2) return redirect('/');
        return view('coordinador.dashboard');
    })->name('coordinador.dashboard');

    Route::get('/estudiante/dashboard', [EstudianteDashboardController::class, 'index'])
        ->name('estudiante.dashboard');

    Route::get('/estudiante/nueva-solicitud', [EstudianteDashboardController::class, 'createSolicitud'])
        ->name('estudiante.nuevaSolicitud');

    Route::get('/estudiante/nueva-solicitud/detalles', [EstudianteDashboardController::class, 'detallesSolicitud'])
        ->name('estudiante.nuevaSolicitudDetalles');

    Route::get('/estudiante/mis-solicitudes', [EstudianteDashboardController::class, 'misSolicitudes'])
        ->name('estudiante.misSolicitudes');

    Route::get('/estudiante/mi-perfil', [EstudianteDashboardController::class, 'miPerfil'])
        ->name('estudiante.miPerfil');
    Route::post('/estudiante/mi-perfil', [EstudianteDashboardController::class, 'updatePerfil'])
        ->name('estudiante.updatePerfil');

    Route::get('/estudiante/nueva-solicitud/documentacion', [EstudianteDashboardController::class, 'documentacionSolicitud'])
        ->name('estudiante.nuevaSolicitudDocumentacion');

    Route::get('/empresa/dashboard', function () {
        if (Auth::user()->rol_id != 4) return redirect('/');
        return view('empresa.dashboard');
    })->name('empresa.dashboard');
});
