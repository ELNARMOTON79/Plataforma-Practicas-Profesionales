<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Esquema completo de la base de datos "practicas".
 *
 * Crea todas las tablas del sistema en una sola migración, con el estado actual
 * de la base más las columnas de las migraciones pendientes que el código ya usa
 * (estudiantes.activo_practica, asesor, coasesor y proyectos.estudiante_id).
 *
 * Está en su propia carpeta para que no choque con las migraciones incrementales
 * de database/migrations. Para crear la base desde cero:
 *
 *   php artisan migrate:fresh --path=database/migrations/esquema_completo
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ---------------------------------------------------------------
        // Usuarios y roles
        // ---------------------------------------------------------------
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_rol', 100);
        });

        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('correo', 255)->unique('correo');
            $table->string('contraseña', 255);
            $table->boolean('activo')->default(true);
            $table->unsignedInteger('rol_id');

            $table->foreign('rol_id', 'fk_usuarios_rol')
                  ->references('id')->on('roles')
                  ->onUpdate('cascade');
        });

        Schema::create('estudiantes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('usuario_id');
            $table->string('nombre_completo', 255);
            $table->string('primer_nombre', 150)->nullable();
            $table->string('apellidos', 150)->nullable();
            $table->string('matricula', 50)->unique('matricula');
            $table->string('carrera', 150);
            $table->unsignedTinyInteger('semestre');
            $table->string('grupo', 20);
            $table->string('direccion', 500)->nullable();
            $table->string('telefono', 50)->nullable();
            $table->boolean('activo_practica')->default(false);
            $table->string('asesor', 255)->nullable();
            $table->string('coasesor', 255)->nullable();

            $table->foreign('usuario_id', 'fk_estudiantes_usuario')
                  ->references('id')->on('usuarios')
                  ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('personal', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('usuario_id');
            $table->string('nombre_completo', 255);

            $table->foreign('usuario_id', 'fk_personal_usuario')
                  ->references('id')->on('usuarios')
                  ->onDelete('cascade')->onUpdate('cascade');
        });

        // ---------------------------------------------------------------
        // Unidades receptoras, convenios y proyectos
        // ---------------------------------------------------------------
        Schema::create('unidades_receptoras', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('usuario_id');
            $table->string('nombre_empresa', 255);
            $table->string('direccion', 500);
            $table->string('tipo_persona', 50)->comment('Física o Moral');
            $table->string('sistema', 50)->nullable();
            $table->string('sector', 50)->nullable();
            $table->string('unidad_receptora', 100)->nullable();
            $table->string('titular', 100)->nullable();
            $table->string('cargo', 100)->nullable();
            $table->string('colonia', 50)->nullable();
            $table->integer('cp')->nullable();
            $table->string('estado', 20)->nullable();
            $table->string('municipio', 100)->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('convenio', 50)->nullable();

            $table->foreign('usuario_id', 'fk_ur_usuario')
                  ->references('id')->on('usuarios')
                  ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('convenios', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ur_id');
            $table->string('codigo_convenio', 100);
            $table->date('fecha_inicio');
            $table->date('fecha_termino');
            $table->enum('estatus', ['activo', 'inactivo', 'pendiente'])->default('pendiente');

            $table->unique(['codigo_convenio', 'ur_id'], 'convenios_codigo_ur_unique');
            $table->foreign('ur_id', 'fk_convenios_ur')
                  ->references('id')->on('unidades_receptoras')
                  ->onUpdate('cascade');
        });

        Schema::create('proyectos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('unidad_receptora_id');
            $table->unsignedInteger('estudiante_id')->nullable();
            $table->string('titulo', 255);
            $table->text('objetivo');
            $table->text('justificacion');
            $table->text('actividades');
            $table->text('impacto_social');
            $table->string('tipo_proyecto', 150);
            $table->string('tipo_modalidad', 150);
            $table->string('plan', 50);
            $table->string('ciclo_escolar', 100);
            $table->unsignedTinyInteger('cupos_totales')->default(1);
            $table->unsignedTinyInteger('cupos_ocupados')->default(0);
            $table->enum('publico_internet', ['SI', 'NO'])->default('SI');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('unidad_receptora_id')
                  ->references('id')->on('unidades_receptoras')
                  ->onDelete('cascade');
            $table->foreign('estudiante_id')
                  ->references('id')->on('estudiantes')
                  ->onDelete('set null');
        });

        // ---------------------------------------------------------------
        // Solicitudes de práctica, documentos y horas
        // ---------------------------------------------------------------
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('estudiante_id');
            $table->unsignedInteger('ur_id');
            $table->string('responsable', 255);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->unsignedTinyInteger('horas_por_dia')->default(8);
            $table->string('modalidad', 30)->nullable();
            $table->enum('estatus', ['pendiente', 'aprobada', 'rechazada', 'en_proceso', 'finalizada'])
                  ->default('pendiente');
            $table->text('observaciones')->nullable();

            $table->foreign('estudiante_id', 'fk_solicitudes_estudiante')
                  ->references('id')->on('estudiantes')
                  ->onUpdate('cascade');
            $table->foreign('ur_id', 'fk_solicitudes_ur')
                  ->references('id')->on('unidades_receptoras')
                  ->onUpdate('cascade');
        });

        Schema::create('documentos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('solicitud_id');
            $table->unsignedInteger('ur_id');
            $table->string('nombre_doc', 255);
            $table->string('ruta_archivo', 500);
            $table->date('fecha_carga')->default(DB::raw('(CURRENT_DATE)'));
            $table->string('estatus', 20)->default('pendiente');
            $table->text('observaciones')->nullable();

            $table->foreign('solicitud_id', 'fk_documentos_solicitud')
                  ->references('id')->on('solicitudes')
                  ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ur_id', 'fk_documentos_ur')
                  ->references('id')->on('unidades_receptoras')
                  ->onUpdate('cascade');
        });

        Schema::create('horas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('solicitud_id');
            $table->date('fecha_registro');
            $table->decimal('cantidad_horas', 5, 2);

            $table->foreign('solicitud_id', 'fk_horas_solicitud')
                  ->references('id')->on('solicitudes')
                  ->onDelete('cascade')->onUpdate('cascade');
        });

        // ---------------------------------------------------------------
        // Bitácora del sistema
        // ---------------------------------------------------------------
        Schema::create('bitacora', function (Blueprint $table) {
            $table->id();
            $table->timestamp('timestamp')->useCurrent();
            $table->string('level', 20)->default('info'); // success, info, warning, danger
            $table->string('level_name', 50)->default('Info');
            $table->string('user', 255)->default('Sistema');
            $table->string('user_role', 100)->default('Sistema');
            $table->string('user_email', 255)->nullable();
            $table->string('module', 100);
            $table->string('action', 255);
            $table->text('description');
            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('payload')->nullable();
            $table->timestamps();
        });

        // ---------------------------------------------------------------
        // Tablas internas de Laravel
        // ---------------------------------------------------------------
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->bigInteger('expiration')->index();
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->bigInteger('expiration')->index();
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedSmallInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('connection');
            $table->string('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();

            $table->index(['connection', 'queue', 'failed_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('bitacora');
        Schema::dropIfExists('horas');
        Schema::dropIfExists('documentos');
        Schema::dropIfExists('solicitudes');
        Schema::dropIfExists('proyectos');
        Schema::dropIfExists('convenios');
        Schema::dropIfExists('unidades_receptoras');
        Schema::dropIfExists('personal');
        Schema::dropIfExists('estudiantes');
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('roles');
    }
};
