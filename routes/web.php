<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Estudiante\DashboardController;

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

    Route::get('/coordinador/dashboard', [App\Http\Controllers\Coordinador\DashboardController::class, 'dashboard'])->name('coordinador.dashboard');

    Route::get('/coordinador/instituciones', [App\Http\Controllers\Coordinador\InstitucionController::class, 'instituciones'])->name('coordinador.instituciones');
    Route::post('/coordinador/instituciones', [App\Http\Controllers\Coordinador\InstitucionController::class, 'storeInstitucion'])->name('coordinador.instituciones.store');
    Route::post('/coordinador/instituciones/bulk-store', [App\Http\Controllers\Coordinador\InstitucionController::class, 'bulkStoreInstituciones'])->name('coordinador.instituciones.bulk-store');

    Route::get('/coordinador/alumnos', [App\Http\Controllers\Coordinador\AlumnoController::class, 'alumnos'])->name('coordinador.alumnos');
    Route::post('/coordinador/alumnos/bulk-store', [App\Http\Controllers\Coordinador\AlumnoController::class, 'bulkStoreAlumnos'])->name('coordinador.alumnos.bulk-store');
    Route::post('/coordinador/alumnos', [App\Http\Controllers\Coordinador\AlumnoController::class, 'storeAlumno'])->name('coordinador.alumnos.store');
    Route::put('/coordinador/alumnos/{id}', [App\Http\Controllers\Coordinador\AlumnoController::class, 'updateAlumno'])->name('coordinador.alumnos.update');

    Route::get('/coordinador/proyectos', [App\Http\Controllers\Coordinador\ProyectoController::class, 'proyectos'])->name('coordinador.proyectos');
    Route::post('/coordinador/proyectos', [App\Http\Controllers\Coordinador\ProyectoController::class, 'storeProyecto'])->name('coordinador.proyectos.store');
    Route::put('/coordinador/proyectos/{id}', [App\Http\Controllers\Coordinador\ProyectoController::class, 'updateProyecto'])->name('coordinador.proyectos.update');
    Route::patch('/coordinador/proyectos/{id}/toggle-status', [App\Http\Controllers\Coordinador\ProyectoController::class, 'toggleProyectoStatus'])->name('coordinador.proyectos.toggle-status');

    Route::get('/coordinador/tramites', [App\Http\Controllers\Coordinador\TramiteController::class, 'tramites'])->name('coordinador.tramites');
    Route::patch('/coordinador/tramites/solicitud/{id}/aprobar', [App\Http\Controllers\Coordinador\TramiteController::class, 'aprobarSolicitud'])->name('coordinador.tramites.solicitud.aprobar');
    Route::patch('/coordinador/tramites/solicitud/{id}/rechazar', [App\Http\Controllers\Coordinador\TramiteController::class, 'rechazarSolicitud'])->name('coordinador.tramites.solicitud.rechazar');

    Route::get('/coordinador/seguimiento', [App\Http\Controllers\Coordinador\SeguimientoController::class, 'index'])->name('coordinador.seguimiento');
    Route::get('/coordinador/seguimiento/{id}', [App\Http\Controllers\Coordinador\SeguimientoController::class, 'show'])->name('coordinador.seguimiento.show');
    Route::post('/coordinador/seguimiento/{id}/save-notes', [App\Http\Controllers\Coordinador\SeguimientoController::class, 'saveNotes'])->name('coordinador.seguimiento.save-notes');
    Route::post('/coordinador/seguimiento/{id}/save-responsable', [App\Http\Controllers\Coordinador\SeguimientoController::class, 'saveResponsable'])->name('coordinador.seguimiento.save-responsable');

    Route::get('/coordinador/informes', function () {
        if (auth()->user()->rol_id != 2) return redirect('/');
        $carreras = \App\Models\Alumno::distinct()->pluck('carrera')->filter()->values();
        return view('coordinador.informes', compact('carreras'));
    })->name('coordinador.informes');

    Route::get('/coordinador/perfil', [App\Http\Controllers\Coordinador\PerfilController::class, 'perfil'])->name('coordinador.perfil');
    Route::post('/coordinador/perfil/password', [App\Http\Controllers\Coordinador\PerfilController::class, 'updatePassword'])->name('coordinador.perfil.password');

    Route::get('/estudiante/dashboard', [DashboardController::class, 'index'])->name('estudiante.dashboard');

    Route::get('/estudiante/convenios', [DashboardController::class, 'convenios'])->name('estudiante.convenios');
    Route::get('/estudiante/mi-perfil', [DashboardController::class, 'miPerfil'])->name('estudiante.miPerfil');
    Route::post('/estudiante/mi-perfil', [DashboardController::class, 'updatePerfil'])->name('estudiante.updatePerfil');
    Route::post('/estudiante/cambiar-contrasena', [DashboardController::class, 'changePassword'])->name('estudiante.changePassword');

    Route::get('/estudiante/proyecto', [DashboardController::class, 'miProyecto'])->name('estudiante.proyecto');
    Route::get('/estudiante/proyecto/carta-presentacion', [DashboardController::class, 'generarCartaPresentacion'])->name('estudiante.cartaPresentacionPdf');
    Route::get('/estudiante/proyecto/plan-trabajo', [DashboardController::class, 'generarPlanTrabajo'])->name('estudiante.planTrabajoPdf');
    Route::get('/estudiante/proyecto/memoria-practicas', [DashboardController::class, 'generarMemoriaPracticas'])->name('estudiante.memoriaPracticasPdf');
    Route::get('/estudiante/proyecto/carta-termino', [DashboardController::class, 'generarCartaTermino'])->name('estudiante.cartaTerminoWord');
    Route::post('/estudiante/proyecto/documento', [DashboardController::class, 'subirDocumento'])->name('estudiante.subirDocumento');
    Route::delete('/estudiante/documento/{id}', [DashboardController::class, 'eliminarDocumento'])->name('estudiante.eliminarDocumento');
    Route::get('/estudiante/mis-solicitudes', [DashboardController::class, 'misSolicitudes'])->name('estudiante.misSolicitudes');
    Route::post('/estudiante/solicitudes', [DashboardController::class, 'storeSolicitud'])->name('estudiante.storeSolicitud');

    Route::get('/empresa/dashboard', function () {
        if (Auth::user()->rol_id != 4) return redirect('/');
        return view('empresa.dashboard');
    })->name('empresa.dashboard');

    Route::get('/empresa/proyectos', function () {
        if (Auth::user()->rol_id != 4) return redirect('/');
        return view('empresa.proyectos');
    })->name('empresa.proyectos');

    Route::get('/empresa/solicitudes', function () {
        if (Auth::user()->rol_id != 4) return redirect('/');
        return view('empresa.solicitudes');
    })->name('empresa.solicitudes');

    Route::get('/empresa/reportes', function () {
        if (Auth::user()->rol_id != 4) return redirect('/');
        return view('empresa.reportes');
    })->name('empresa.reportes');

    Route::get('/empresa/convenios', function () {
        if (Auth::user()->rol_id != 4) return redirect('/');
        return view('empresa.convenios');
    })->name('empresa.convenios');

    Route::get('/empresa/perfil', function () {
        if (Auth::user()->rol_id != 4) return redirect('/');
        return view('empresa.perfil');
    })->name('empresa.perfil');
});
