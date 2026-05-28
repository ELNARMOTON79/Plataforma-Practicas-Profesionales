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

Route::get('/recuperar-contrasena', function () {
    return view('recuperar_contraseña');
})->name('recuperar-contrasena');

Route::post('/recuperar-contrasena', [AuthController::class, 'enviarEnlaceRecuperacion'])->name('recuperar-contrasena.post');
Route::get('/restablecer-contrasena/{token}', [AuthController::class, 'mostrarFormularioRestablecer'])->name('restablecer-contrasena.form');
Route::post('/restablecer-contrasena', [AuthController::class, 'restablecerContrasena'])->name('restablecer-contrasena.post');

// Authentication routes
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected dashboard routes
Route::middleware(['auth', 'prevent-back-history', 'check-maintenance'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/admin/config', [App\Http\Controllers\AdminController::class, 'config'])->name('admin.config');
    Route::post('/admin/config/profile', [App\Http\Controllers\AdminController::class, 'updateProfile'])->name('admin.config.profile');
    Route::post('/admin/config/password', [App\Http\Controllers\AdminController::class, 'updatePassword'])->name('admin.config.password');
    Route::post('/admin/config/settings', [App\Http\Controllers\AdminController::class, 'updateSettings'])->name('admin.config.settings');
    Route::post('/admin/config/clean-logs', [App\Http\Controllers\AdminController::class, 'cleanLogsNow'])->name('admin.config.clean-logs');

    Route::get('/admin/usuarios', [App\Http\Controllers\AdminController::class, 'usuarios'])->name('admin.usuarios');
    Route::post('/admin/usuarios', [App\Http\Controllers\AdminController::class, 'storeUsuario'])->name('admin.usuarios.store');
    Route::post('/admin/usuarios/bulk-store', [App\Http\Controllers\AdminController::class, 'bulkStoreUsuarios'])->name('admin.usuarios.bulk-store');
    Route::put('/admin/usuarios/{id}', [App\Http\Controllers\AdminController::class, 'updateUsuario'])->name('admin.usuarios.update');
    Route::patch('/admin/usuarios/{id}/toggle-status', [App\Http\Controllers\AdminController::class, 'toggleStatus'])->name('admin.usuarios.toggle-status');

    Route::get('/admin/bitacora', [App\Http\Controllers\AdminController::class, 'bitacora'])->name('admin.bitacora');
    Route::post('/admin/bitacora/clear', [App\Http\Controllers\AdminController::class, 'clearBitacora'])->name('admin.bitacora.clear');
    Route::get('/admin/bitacora/export', [App\Http\Controllers\AdminController::class, 'exportBitacora'])->name('admin.bitacora.export');

    Route::get('/coordinador/dashboard', [App\Http\Controllers\CoordinadorController::class, 'dashboard'])->name('coordinador.dashboard');

    Route::get('/coordinador/instituciones', [App\Http\Controllers\CoordinadorController::class, 'instituciones'])->name('coordinador.instituciones');

    Route::get('/coordinador/alumnos', [App\Http\Controllers\CoordinadorController::class, 'alumnos'])->name('coordinador.alumnos');

    Route::post('/coordinador/alumnos', [App\Http\Controllers\CoordinadorController::class, 'storeAlumno'])->name('coordinador.alumnos.store');

    Route::get('/coordinador/proyectos', [App\Http\Controllers\CoordinadorController::class, 'proyectos'])->name('coordinador.proyectos');
    Route::post('/coordinador/proyectos', [App\Http\Controllers\CoordinadorController::class, 'storeProyecto'])->name('coordinador.proyectos.store');
    Route::put('/coordinador/proyectos/{id}', [App\Http\Controllers\CoordinadorController::class, 'updateProyecto'])->name('coordinador.proyectos.update');
    Route::patch('/coordinador/proyectos/{id}/toggle-status', [App\Http\Controllers\CoordinadorController::class, 'toggleProyectoStatus'])->name('coordinador.proyectos.toggle-status');

    Route::get('/coordinador/tramites', function () {
        if (auth()->user()->rol_id != 2) return redirect('/');
        return view('coordinador.tramites');
    })->name('coordinador.tramites');

    Route::get('/coordinador/informes', function () {
        if (auth()->user()->rol_id != 2) return redirect('/');
        return view('coordinador.informes');
    })->name('coordinador.informes');

    Route::get('/coordinador/perfil', [App\Http\Controllers\CoordinadorController::class, 'perfil'])->name('coordinador.perfil');
    Route::post('/coordinador/perfil/password', [App\Http\Controllers\CoordinadorController::class, 'updatePassword'])->name('coordinador.perfil.password');

    Route::get('/estudiante/dashboard', function () {
        if (auth()->user()->rol_id != 3) return redirect('/');
        return view('estudiante.dashboard');
    })->name('estudiante.dashboard');

    Route::get('/estudiante/convenios', function () {
        if (auth()->user()->rol_id != 3) return redirect('/');
        return view('estudiante.convenios');
    })->name('estudiante.convenios');

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
