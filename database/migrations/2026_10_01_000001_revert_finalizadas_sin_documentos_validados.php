<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Documents the coordinator must validate before practice hours start counting
     * (same list as Solicitud::DOCUMENTOS_INICIALES).
     */
    private const DOCUMENTOS_INICIALES = [
        'Carta de Presentación',
        'Carta de Aceptación',
        'Plan de Trabajo',
    ];

    /**
     * Run the migrations.
     *
     * Practices marked as finalizada only because fecha_fin passed, without the
     * initial documents validated, go back to en_proceso.
     */
    public function up(): void
    {
        $requeridos = array_map(fn ($nombre) => mb_strtolower($nombre), self::DOCUMENTOS_INICIALES);

        $solicitudIds = DB::table('solicitudes')
            ->where('estatus', 'finalizada')
            ->pluck('id');

        foreach ($solicitudIds as $solicitudId) {
            $validados = DB::table('documentos')
                ->where('solicitud_id', $solicitudId)
                ->where('estatus', 'validado')
                ->pluck('nombre_doc')
                ->map(fn ($nombre) => mb_strtolower(trim($nombre)));

            $completos = collect($requeridos)->every(fn ($requerido) => $validados->contains($requerido));

            if (! $completos) {
                DB::table('solicitudes')
                    ->where('id', $solicitudId)
                    ->update(['estatus' => 'en_proceso']);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * Data-only fix: the previous estatus is not recoverable, and
     * Solicitud::sincronizarEstatus() moves practices to finalizada
     * again once they meet the requirements.
     */
    public function down(): void
    {
        //
    }
};
