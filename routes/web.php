<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

    Route::get('/coordinador/dashboard', function () {
        if (auth()->user()->rol_id != 2) return redirect('/');
        return view('coordinador.dashboard');
    })->name('coordinador.dashboard');

    Route::get('/estudiante/dashboard', function () {
        if (auth()->user()->rol_id != 3) return redirect('/');
        return view('estudiante.dashboard');
    })->name('estudiante.dashboard');

    Route::get('/empresa/dashboard', function () {
        if (auth()->user()->rol_id != 4) return redirect('/');
        return view('empresa.dashboard');
    })->name('empresa.dashboard');
});
