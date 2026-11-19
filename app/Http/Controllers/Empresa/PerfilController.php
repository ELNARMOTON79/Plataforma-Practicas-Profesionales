<?php

namespace App\Http\Controllers\Empresa;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\UnidadReceptora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Perfil de la unidad receptora (empresa): datos de la empresa y cambio de contraseña.
 */
class PerfilController extends Controller
{
    public function perfil()
    {
        if (auth()->user()->rol_id != 4) {
            return redirect('/');
        }

        $unidades = UnidadReceptora::where('usuario_id', auth()->id())->orderBy('unidad_receptora')->get();

        return view('empresa.perfil', [
            'empresa' => $unidades->first()?->nombre_empresa ?? 'Mi empresa',
            'unidades' => $unidades,
        ]);
    }

    public function actualizarContrasena(Request $request)
    {
        if (auth()->user()->rol_id != 4) {
            return redirect('/');
        }

        $user = auth()->user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed|different:current_password',
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'password.different' => 'La nueva contraseña debe ser diferente a la actual.',
        ]);

        if (! Hash::check($request->input('current_password'), $user->contraseña)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }

        $user->contraseña = Hash::make($request->input('password'));
        $user->save();

        // Cierra las sesiones abiertas en otros dispositivos (SESSION_DRIVER=database) y conserva la actual
        DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '!=', $request->session()->getId())
            ->delete();

        ActivityLogger::log('Configuración', 'Contraseña Cambiada', 'La empresa cambió su contraseña de acceso.', 'warning');

        return redirect()->route('empresa.perfil')->with('success', 'Contraseña actualizada correctamente. Se cerró tu sesión en otros dispositivos.');
    }
}
