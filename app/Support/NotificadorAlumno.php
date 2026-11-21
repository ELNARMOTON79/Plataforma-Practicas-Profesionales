<?php

namespace App\Support;

use App\Mail\NotificacionAlumno;
use App\Models\Documento;
use Illuminate\Database\Eloquent\Model;
use App\Models\Proyecto;
use App\Models\Solicitud;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Correos al alumno cuando el coordinador decide sobre sus trámites o la empresa registra sus horas.
 * Un fallo del servidor de correo se registra en el log y no interrumpe la acción que lo disparó.
 */
class NotificadorAlumno
{
    public static function solicitud(Solicitud $solicitud): void
    {
        $solicitud->loadMissing(['estudiante.usuario', 'unidadReceptora']);
        $ur = $solicitud->unidadReceptora;
        $empresa = $ur ? trim(($ur->nombre_empresa ?? '') . ($ur->unidad_receptora ? " ({$ur->unidad_receptora})" : '')) : 'la empresa';

        if ($solicitud->estatus === 'aprobada') {
            $porDefinir = $solicitud->ya_labora ? 'La definirá la empresa' : 'Por definir';

            self::enviar($solicitud->estudiante, new NotificacionAlumno(
                titulo: 'Tu solicitud de prácticas fue aprobada',
                resultado: 'aprobado',
                nombreAlumno: self::nombre($solicitud->estudiante),
                mensaje: "El coordinador aprobó tu solicitud de prácticas en {$empresa}.",
                detalles: array_filter([
                    'Empresa'          => $empresa,
                    'Fecha de inicio'  => $solicitud->fecha_inicio?->format('d/m/Y') ?? $porDefinir,
                    'Término estimado' => $solicitud->fecha_fin?->format('d/m/Y') ?? $porDefinir,
                    'Horas por día'    => $solicitud->fecha_inicio ? $solicitud->horasPorDia() . ' h' : null,
                ]),
                observaciones: $solicitud->observaciones,
                siguientePaso: 'Ya puedes registrar tu proyecto y descargar tu carta de presentación desde "Mi proyecto".',
                urlAccion: route('estudiante.proyecto'),
                textoBoton: 'Ir a mi proyecto',
            ));
        } elseif ($solicitud->estatus === 'rechazada') {
            self::enviar($solicitud->estudiante, new NotificacionAlumno(
                titulo: 'Tu solicitud de prácticas fue rechazada',
                resultado: 'rechazado',
                nombreAlumno: self::nombre($solicitud->estudiante),
                mensaje: "El coordinador rechazó tu solicitud de prácticas en {$empresa}.",
                observaciones: $solicitud->observaciones,
                siguientePaso: 'Puedes enviar una nueva solicitud desde la sección "Convenios".',
                urlAccion: route('estudiante.convenios'),
                textoBoton: 'Ver convenios',
            ));
        }
    }

    public static function documento(Documento $documento): void
    {
        $documento->loadMissing('solicitud.estudiante.usuario');
        $estudiante = $documento->solicitud?->estudiante;
        $aprobado = $documento->estaValidado();

        if (! $aprobado && $documento->estatus !== 'rechazado') {
            return;
        }

        self::enviar($estudiante, new NotificacionAlumno(
            titulo: $aprobado ? "Tu documento «{$documento->nombre_doc}» fue validado" : "Tu documento «{$documento->nombre_doc}» fue rechazado",
            resultado: $aprobado ? 'aprobado' : 'rechazado',
            nombreAlumno: self::nombre($estudiante),
            mensaje: $aprobado
                ? "El coordinador validó tu documento «{$documento->nombre_doc}»."
                : "El coordinador rechazó tu documento «{$documento->nombre_doc}».",
            detalles: array_filter([
                'Documento'      => $documento->nombre_doc,
                'Fecha de carga' => $documento->fecha_carga?->format('d/m/Y'),
            ]),
            observaciones: $documento->observaciones,
            siguientePaso: $aprobado
                ? 'Si te faltan documentos de tu expediente, ya puedes subir el siguiente.'
                : 'Corrige el documento y vuelve a subirlo desde "Mi proyecto".',
            urlAccion: route('estudiante.proyecto'),
            textoBoton: 'Ir a mi expediente',
        ));
    }

    public static function proyecto(Proyecto $proyecto): void
    {
        if (! $proyecto->estudiante_id || ! in_array($proyecto->estatus, ['aprobado', 'rechazado'], true)) {
            return;
        }

        $proyecto->loadMissing('estudiante.usuario');
        $aprobado = $proyecto->estatus === 'aprobado';

        self::enviar($proyecto->estudiante, new NotificacionAlumno(
            titulo: $aprobado ? 'Tu proyecto fue aprobado' : 'Tu proyecto fue rechazado',
            resultado: $aprobado ? 'aprobado' : 'rechazado',
            nombreAlumno: self::nombre($proyecto->estudiante),
            mensaje: $aprobado
                ? "El coordinador aprobó tu proyecto «{$proyecto->titulo}»."
                : "El coordinador rechazó tu proyecto «{$proyecto->titulo}».",
            detalles: array_filter([
                'Proyecto'  => $proyecto->titulo,
                'Tipo'      => $proyecto->tipo_proyecto,
                'Modalidad' => $proyecto->tipo_modalidad,
            ]),
            observaciones: $proyecto->observaciones,
            siguientePaso: $aprobado
                ? 'Continúa con tu expediente y tus prácticas desde "Mi proyecto".'
                : 'Corrige tu proyecto con estas observaciones y vuelve a enviarlo desde "Mi proyecto".',
            urlAccion: route('estudiante.proyecto'),
            textoBoton: 'Ir a mi proyecto',
        ));
    }

    /**
     * @param  array  $semana  Semana de Solicitud::semanasDeRegistro() (inicio, fin, registradas).
     */
    public static function horas(Solicitud $solicitud, array $semana, float $horas): void
    {
        $solicitud->loadMissing(['estudiante.usuario', 'unidadReceptora']);
        $solicitud->unsetRelation('horas');

        $acumuladas = $solicitud->horasCompletadas();
        $meta = $solicitud->horasMeta();
        $rango = $semana['inicio']->format('d/m/Y') . ' al ' . $semana['fin']->format('d/m/Y');
        $correccion = $semana['registradas'] !== null;
        $empresa = $solicitud->unidadReceptora?->nombre_empresa ?? 'La empresa';

        self::enviar($solicitud->estudiante, new NotificacionAlumno(
            titulo: $correccion ? 'Se corrigieron tus horas de la semana' : 'Se registraron tus horas de la semana',
            resultado: 'informativo',
            nombreAlumno: self::nombre($solicitud->estudiante),
            mensaje: $correccion
                ? "{$empresa} corrigió tus horas de la semana del {$rango}."
                : "{$empresa} registró tus horas de la semana del {$rango}.",
            detalles: array_filter([
                'Semana'             => $rango,
                'Horas de la semana' => self::numero($horas) . ' h',
                'Registro anterior'  => $correccion ? self::numero((float) $semana['registradas']) . ' h' : null,
                'Total acumulado'    => self::numero($acumuladas) . ' de ' . $meta . ' h (' . ($meta > 0 ? (int) floor($acumuladas / $meta * 100) : 0) . '%)',
            ]),
            siguientePaso: $acumuladas >= $meta ? '¡Completaste las horas de tu práctica!' : null,
            urlAccion: route('estudiante.dashboard'),
            textoBoton: 'Ver mi avance',
        ));
    }

    /** @param  Model|null  $estudiante  Estudiante o Alumno (ambos modelos usan la tabla estudiantes). */
    private static function enviar(?Model $estudiante, NotificacionAlumno $correo): void
    {
        $destinatario = $estudiante?->usuario?->correo;

        if (! $destinatario) {
            Log::warning("No se pudo notificar al alumno ({$correo->titulo}): no tiene correo registrado.");
            return;
        }

        try {
            Mail::to($destinatario)->send($correo);
        } catch (\Throwable $e) {
            Log::error("Error al enviar «{$correo->titulo}» al alumno {$destinatario}: " . $e->getMessage());
        }
    }

    private static function nombre(?Model $estudiante): string
    {
        return $estudiante?->primer_nombre ?: ($estudiante?->nombre_completo ?: 'estudiante');
    }

    private static function numero(float $valor): string
    {
        return rtrim(rtrim(number_format($valor, 2, '.', ''), '0'), '.');
    }
}
