<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\UnidadReceptora;
use App\Mail\NewAssociationNotification;
use App\Helpers\SystemSettings;
use App\Helpers\ActivityLogger;

class UnidadReceptoraController extends Controller
{
    /**
     * Store a new Unidad Receptora directly for an existing institution.
     */
    public function storeUnidadReceptora(Request $request)
    {
        if (auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        $request->validate([
            'nombre_empresa'    => ['required', 'string', 'max:255'],
            'titular'           => ['required', 'string', 'max:100'],
            'cargo'             => ['required', 'string', 'max:100'],
            'unidad_receptora'  => ['nullable', 'string', 'max:100'],
            'telefono'          => ['nullable', 'string', 'max:50'],
            'direccion'         => ['nullable', 'string', 'max:500'],
            'municipio'         => ['nullable', 'string', 'max:100'],
        ], [
            'nombre_empresa.required' => 'La empresa u institución es requerida.',
            'titular.required'        => 'El nombre del titular es obligatorio.',
            'cargo.required'          => 'El cargo del titular es obligatorio.',
        ]);

        $nombreEmpresa = trim($request->input('nombre_empresa'));
        $unidadReceptoraName = trim($request->input('unidad_receptora') ?? '');

        // Find an existing UR base for this empresa to inherit default values (usuario_id, direccion, etc.)
        $baseUr = UnidadReceptora::where(DB::raw('LOWER(TRIM(nombre_empresa))'), strtolower($nombreEmpresa))->first();

        if (!$baseUr) {
            return back()->withErrors(['nombre_empresa' => 'No se encontró la institución especificada en el sistema.'])->withInput();
        }

        // Check if this exact UR name already exists for this empresa
        $exists = UnidadReceptora::where(DB::raw('LOWER(TRIM(nombre_empresa))'), strtolower($nombreEmpresa))
            ->where(function($q) use ($unidadReceptoraName) {
                if ($unidadReceptoraName === '') {
                    $q->whereNull('unidad_receptora')
                      ->orWhere(DB::raw('TRIM(unidad_receptora)'), '');
                } else {
                    $q->where(DB::raw('LOWER(TRIM(unidad_receptora))'), strtolower($unidadReceptoraName));
                }
            })
            ->exists();

        if ($exists) {
            return back()->withErrors(['unidad_receptora' => "La Unidad Receptora '" . ($unidadReceptoraName ?: 'General') . "' ya se encuentra registrada para {$nombreEmpresa}."])->withInput();
        }

        DB::beginTransaction();
        try {
            $ur = new UnidadReceptora();
            $ur->usuario_id = $baseUr->usuario_id;
            $ur->nombre_empresa = $baseUr->nombre_empresa;
            $ur->direccion = trim($request->input('direccion')) ?: $baseUr->direccion;
            $ur->tipo_persona = $baseUr->tipo_persona ?: 'Moral';
            $ur->sistema = $baseUr->sistema;
            $ur->sector = $baseUr->sector;
            $ur->unidad_receptora = $unidadReceptoraName;
            $ur->titular = trim($request->input('titular'));
            $ur->cargo = trim($request->input('cargo'));
            $ur->colonia = $baseUr->colonia;
            $ur->cp = $baseUr->cp;
            $ur->estado = $baseUr->estado;
            $ur->municipio = trim($request->input('municipio')) ?: $baseUr->municipio;
            $ur->telefono = trim($request->input('telefono')) ?: $baseUr->telefono;
            $ur->convenio = $baseUr->convenio ?: 'Con Convenio';
            $ur->save();

            // Send notification email to company user if enabled
            $user = User::find($baseUr->usuario_id);
            if ($user && SystemSettings::get('send_emails', true)) {
                try {
                    $unitsAdded = [[
                        'nombre_empresa' => $ur->nombre_empresa,
                        'unidad_receptora' => $ur->unidad_receptora ?: 'General'
                    ]];
                    Mail::to($user->correo)->send(new NewAssociationNotification($user, $ur->titular, $unitsAdded));
                } catch (\Exception $e) {
                    \Log::error("Error al enviar correo en registro directo de UR: " . $e->getMessage());
                }
            }

            DB::commit();

            ActivityLogger::log(
                'Instituciones',
                'Registro de UR',
                "Se agregó la Unidad Receptora '" . ($ur->unidad_receptora ?: 'General') . "' a la institución '{$ur->nombre_empresa}'.",
                'success'
            );

            return redirect()->route('coordinador.instituciones')
                ->with('success', "Unidad Receptora \"" . ($ur->unidad_receptora ?: 'General') . "\" agregada correctamente a {$ur->nombre_empresa}.");

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Error al registrar nueva UR directamente: " . $e->getMessage());
            return back()->withErrors(['error' => 'Ocurrió un error al agregar la Unidad Receptora: ' . $e->getMessage()])->withInput();
        }
    }
}
