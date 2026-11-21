<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Coordinador\DashboardController as CoordinadorDashboardController;
use App\Http\Controllers\Estudiante\DashboardController;
use App\Http\Controllers\AdminController;

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
Route::middleware(['auth', 'check-maintenance', 'prevent-back-history'])->group(function () {
    // Archivos de documentos: se sirven desde disco privado verificando permisos
    Route::get('/documentos/{id}/archivo', [App\Http\Controllers\DocumentoController::class, 'archivo'])
        ->whereNumber('id')
        ->name('documentos.archivo');

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/admin/config', [App\Http\Controllers\AdminController::class, 'config'])->name('admin.config');
    Route::post('/admin/config/profile', [App\Http\Controllers\AdminController::class, 'updateProfile'])->name('admin.config.profile');
    Route::post('/admin/config/password', [App\Http\Controllers\AdminController::class, 'updatePassword'])->name('admin.config.password');
    Route::post('/admin/config/settings', [App\Http\Controllers\AdminController::class, 'updateSettings'])->name('admin.config.settings');
    Route::post('/admin/config/director', [App\Http\Controllers\AdminController::class, 'updateDirector'])->name('admin.config.director');
    Route::post('/admin/config/clean-logs', [App\Http\Controllers\AdminController::class, 'cleanLogsNow'])->name('admin.config.clean-logs');

    Route::get('/admin/usuarios', [App\Http\Controllers\AdminController::class, 'usuarios'])->name('admin.usuarios');
    Route::post('/admin/usuarios', [App\Http\Controllers\AdminController::class, 'storeUsuario'])->name('admin.usuarios.store');
    Route::post('/admin/usuarios/bulk-store', [App\Http\Controllers\AdminController::class, 'bulkStoreUsuarios'])->name('admin.usuarios.bulk-store');
    Route::put('/admin/usuarios/{id}', [App\Http\Controllers\AdminController::class, 'updateUsuario'])->name('admin.usuarios.update');
    Route::post('/admin/usuarios/{id}/resend-credentials', [App\Http\Controllers\AdminController::class, 'resendCredentials'])->name('admin.usuarios.resend-credentials');
    Route::patch('/admin/usuarios/{id}/toggle-status', [App\Http\Controllers\AdminController::class, 'toggleStatus'])->name('admin.usuarios.toggle-status');

    Route::get('/admin/bitacora', [App\Http\Controllers\AdminController::class, 'bitacora'])->name('admin.bitacora');
    Route::post('/admin/bitacora/clear', [App\Http\Controllers\AdminController::class, 'clearBitacora'])->name('admin.bitacora.clear');
    Route::get('/admin/bitacora/export', [App\Http\Controllers\AdminController::class, 'exportBitacora'])->name('admin.bitacora.export');


    Route::get('/coordinador/dashboard', [CoordinadorDashboardController::class, 'dashboard'])->name('coordinador.dashboard');

    Route::get('/coordinador/instituciones', [App\Http\Controllers\Coordinador\InstitucionController::class, 'instituciones'])->name('coordinador.instituciones');
    Route::post('/coordinador/instituciones', [App\Http\Controllers\Coordinador\InstitucionController::class, 'storeInstitucion'])->name('coordinador.instituciones.store');
    Route::post('/coordinador/instituciones/unidades', [App\Http\Controllers\Coordinador\UnidadReceptoraController::class, 'storeUnidadReceptora'])->name('coordinador.instituciones.store-ur');
    Route::post('/coordinador/instituciones/bulk-store', [App\Http\Controllers\Coordinador\InstitucionController::class, 'bulkStoreInstituciones'])->name('coordinador.instituciones.bulk-store');

    Route::get('/coordinador/alumnos', [App\Http\Controllers\Coordinador\AlumnoController::class, 'alumnos'])->name('coordinador.alumnos');
    Route::post('/coordinador/alumnos', [App\Http\Controllers\Coordinador\AlumnoController::class, 'storeAlumno'])->name('coordinador.alumnos.store');
    Route::post('/coordinador/alumnos/bulk', [App\Http\Controllers\Coordinador\AlumnoController::class, 'bulkStoreAlumnos'])->name('coordinador.alumnos.bulk-store');
    Route::put('/coordinador/alumnos/{id}', [App\Http\Controllers\Coordinador\AlumnoController::class, 'updateAlumno'])->name('coordinador.alumnos.update');

    Route::get('/coordinador/proyectos', [App\Http\Controllers\Coordinador\ProyectoController::class, 'proyectos'])->name('coordinador.proyectos');
    Route::post('/coordinador/proyectos', [App\Http\Controllers\Coordinador\ProyectoController::class, 'storeProyecto'])->name('coordinador.proyectos.store');
    Route::put('/coordinador/proyectos/{id}', [App\Http\Controllers\Coordinador\ProyectoController::class, 'updateProyecto'])->name('coordinador.proyectos.update');
    Route::patch('/coordinador/proyectos/{id}/revisar', [App\Http\Controllers\Coordinador\ProyectoController::class, 'revisarProyecto'])->name('coordinador.proyectos.revisar');
    Route::patch('/coordinador/proyectos/{id}/toggle-status',[App\Http\Controllers\Coordinador\ProyectoController::class, 'toggleProyectoStatus'])->name('coordinador.proyectos.toggle-status');

    Route::get('/coordinador/tramites', [App\Http\Controllers\Coordinador\TramiteController::class, 'tramites'])->name('coordinador.tramites');
    Route::patch('/coordinador/tramites/solicitud/{id}/aprobar', [App\Http\Controllers\Coordinador\TramiteController::class, 'aprobarSolicitud'])->name('coordinador.tramites.solicitud.aprobar');
    Route::patch('/coordinador/tramites/solicitud/{id}/rechazar', [App\Http\Controllers\Coordinador\TramiteController::class, 'rechazarSolicitud'])->name('coordinador.tramites.solicitud.rechazar');
    Route::patch('/coordinador/tramites/proyecto/{id}/aprobar', [App\Http\Controllers\Coordinador\TramiteController::class, 'aprobarProyecto'])->name('coordinador.tramites.proyecto.aprobar');
    Route::patch('/coordinador/tramites/proyecto/{id}/rechazar', [App\Http\Controllers\Coordinador\TramiteController::class, 'rechazarProyecto'])->name('coordinador.tramites.proyecto.rechazar');
    Route::patch('/coordinador/tramites/documento/{id}/validar', [App\Http\Controllers\Coordinador\TramiteController::class, 'validarDocumento'])->name('coordinador.tramites.documento.validar');
    Route::patch('/coordinador/tramites/documento/{id}/rechazar', [App\Http\Controllers\Coordinador\TramiteController::class, 'rechazarDocumento'])->name('coordinador.tramites.documento.rechazar');

    Route::get('/coordinador/seguimiento', [App\Http\Controllers\Coordinador\SeguimientoController::class, 'index'])->name('coordinador.seguimiento');
    Route::get('/coordinador/seguimiento/{id}', [App\Http\Controllers\Coordinador\SeguimientoController::class, 'show'])->name('coordinador.seguimiento.show');
    Route::post('/coordinador/seguimiento/{id}/save-notes', [App\Http\Controllers\Coordinador\SeguimientoController::class, 'saveNotes'])->name('coordinador.seguimiento.save-notes');
    Route::post('/coordinador/seguimiento/{id}/save-responsable', [App\Http\Controllers\Coordinador\SeguimientoController::class, 'saveResponsable'])->name('coordinador.seguimiento.save-responsable');

    Route::get('/coordinador/informes', [App\Http\Controllers\Coordinador\InformeController::class, 'informes'])->name('coordinador.informes');


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
    Route::post('/estudiante/proyecto/registrar', [DashboardController::class, 'registrarProyecto'])->name('estudiante.registrarProyecto');
    Route::post('/estudiante/proyecto/documento',[DashboardController::class, 'subirDocumento'])->name('estudiante.subirDocumento');
    Route::delete('/estudiante/documento/{id}', [DashboardController::class, 'eliminarDocumento'])->name('estudiante.eliminarDocumento');
    Route::get('/estudiante/mis-solicitudes', [DashboardController::class, 'misSolicitudes'])->name('estudiante.misSolicitudes');
    Route::post('/estudiante/solicitudes', [DashboardController::class, 'storeSolicitud'])->name('estudiante.storeSolicitud');
    Route::get('/estudiante/solicitudes/fecha-fin', [DashboardController::class, 'calcularFechaFinSolicitud'])->name('estudiante.calcularFechaFinSolicitud');

    // Unidad receptora (empresa): solo consulta su información y registra horas
    Route::get('/empresa/dashboard', [App\Http\Controllers\Empresa\EmpresaController::class, 'dashboard'])->name('empresa.dashboard');

    // Practicantes de la empresa y registro semanal de horas
    Route::get('/empresa/practicantes', [App\Http\Controllers\Empresa\PracticanteController::class, 'index'])->name('empresa.practicantes');
    Route::get('/empresa/practicantes/{id}', [App\Http\Controllers\Empresa\PracticanteController::class, 'show'])->whereNumber('id')->name('empresa.practicantes.show');
    Route::post('/empresa/practicantes/{id}/horas', [App\Http\Controllers\Empresa\PracticanteController::class, 'registrarHoras'])->whereNumber('id')->name('empresa.practicantes.horas');

    Route::get('/empresa/proyectos', [App\Http\Controllers\Empresa\EmpresaController::class, 'proyectos'])->name('empresa.proyectos');
    Route::get('/empresa/reportes', [App\Http\Controllers\Empresa\EmpresaController::class, 'reportes'])->name('empresa.reportes');
    Route::get('/empresa/convenios', [App\Http\Controllers\Empresa\EmpresaController::class, 'convenio'])->name('empresa.convenios');
    Route::get('/empresa/perfil', [App\Http\Controllers\Empresa\EmpresaController::class, 'perfil'])->name('empresa.perfil');
    Route::post('/empresa/perfil/password', [App\Http\Controllers\Empresa\EmpresaController::class, 'actualizarContrasena'])->name('empresa.perfil.password');

    // La empresa no acepta ni rechaza solicitudes (lo hace el coordinador). Aquí solo define fechas
    // y horario de los alumnos que ya laboran en ella.
    Route::get('/empresa/solicitudes', [App\Http\Controllers\Empresa\SolicitudController::class, 'index'])->name('empresa.solicitudes');
    Route::post('/empresa/solicitudes/{id}/periodo', [App\Http\Controllers\Empresa\SolicitudController::class, 'definirPeriodo'])->whereNumber('id')->name('empresa.solicitudes.periodo');
});
