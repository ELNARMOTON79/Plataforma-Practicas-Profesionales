<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoordinadorController;
use App\Http\Controllers\Estudiante\DashboardController;

Route::get('/', function () {
    // If the user is already authenticated, redirect them to their dashboard
    if (auth()->check()) {
        $roleRoutes = [
            1 => '/admin/dashboard',
            2 => '/coordinador/dashboard',
            3 => '/estudiante/dashboard',
            4 => '/empresa/dashboard',
        ];
        return redirect($roleRoutes[auth()->user()->rol_id] ?? '/');
    }
    return view('welcome');
})->name('login');

// Authentication routes
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected dashboard routes
Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('/admin/dashboard', function () {
        if (auth()->user()->rol_id != 1) return redirect('/');
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/config', function () {
        if (auth()->user()->rol_id != 1) return redirect('/');
        return view('admin.config');
    })->name('admin.config');

    Route::get('/admin/usuarios', function () {
        if (auth()->user()->rol_id != 1) return redirect('/');
        return view('admin.usuarios');
    })->name('admin.usuarios');

    Route::get('/coordinador/dashboard', [CoordinadorController::class, 'dashboard'])->name('coordinador.dashboard');

    Route::get('/coordinador/instituciones', function () {
        if (auth()->user()->rol_id != 2) return redirect('/');
        return view('coordinador.instituciones');
    })->name('coordinador.instituciones');

    Route::get('/coordinador/alumnos', function () {
        if (auth()->user()->rol_id != 2) return redirect('/');
        return view('coordinador.alumnos');
    })->name('coordinador.alumnos');

    Route::get('/coordinador/proyectos', function () {
        if (auth()->user()->rol_id != 2) return redirect('/');
        return view('coordinador.proyectos');
    })->name('coordinador.proyectos');

    Route::get('/coordinador/tramites', function () {
        if (auth()->user()->rol_id != 2) return redirect('/');
        return view('coordinador.tramites');
    })->name('coordinador.tramites');

    Route::get('/coordinador/informes', function () {
        if (auth()->user()->rol_id != 2) return redirect('/');
        return view('coordinador.informes');
    })->name('coordinador.informes');

    Route::get('/coordinador/perfil', function () {
        if (auth()->user()->rol_id != 2) return redirect('/');
        return view('coordinador.perfil');
    })->name('coordinador.perfil');

    Route::get('/estudiante/dashboard', [DashboardController::class, 'index'])->name('estudiante.dashboard');

    Route::get('/estudiante/convenios', [DashboardController::class, 'convenios'])->name('estudiante.convenios');
    Route::get('/estudiante/mi-perfil', [DashboardController::class, 'miPerfil'])->name('estudiante.miPerfil');
    Route::post('/estudiante/mi-perfil', [DashboardController::class, 'updatePerfil'])->name('estudiante.updatePerfil');

    Route::get('/estudiante/proyecto', function () {
        if (auth()->user()->rol_id != 3) return redirect('/');
        return view('estudiante.proyecto');
    })->name('estudiante.proyecto');

    Route::get('/empresa/dashboard', function () {
        if (auth()->user()->rol_id != 4) return redirect('/');
        return view('empresa.dashboard');
    })->name('empresa.dashboard');

    Route::get('/empresa/proyectos', function () {
        if (auth()->user()->rol_id != 4) return redirect('/');
        return view('empresa.proyectos');
    })->name('empresa.proyectos');

    Route::get('/empresa/solicitudes', function () {
        if (auth()->user()->rol_id != 4) return redirect('/');
        return view('empresa.solicitudes');
    })->name('empresa.solicitudes');

    Route::get('/empresa/reportes', function () {
        if (auth()->user()->rol_id != 4) return redirect('/');
        return view('empresa.reportes');
    })->name('empresa.reportes');

    Route::get('/empresa/convenios', function () {
        if (auth()->user()->rol_id != 4) return redirect('/');
        return view('empresa.convenios');
    })->name('empresa.convenios');

    Route::get('/empresa/perfil', function () {
        if (auth()->user()->rol_id != 4) return redirect('/');
        return view('empresa.perfil');
    })->name('empresa.perfil');
});
