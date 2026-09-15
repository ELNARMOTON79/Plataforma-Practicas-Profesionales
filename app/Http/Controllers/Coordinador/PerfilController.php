<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PerfilController extends Controller
{
    /**
     * Show the coordinator profile configuration page.
     */
    public function perfil()
    {
        if (auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        $user = auth()->user();
        $coordinadorName = $user->coordinador->nombre_completo ?? '';

        return view('coordinador.perfil', compact('user', 'coordinadorName'));
    }

    /**
     * Update the coordinator password.
     */
    public function updatePassword(Request $request)
    {
        if (auth()->user()->rol_id != 2) {
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
            'password.different' => 'La nueva contraseña debe ser diferente a la contraseña actual.',
        ]);

        // Verify current password
        if (!Hash::check($request->input('current_password'), $user->contraseña)) {
            return back()->withErrors(['current_password' => 'La contraseña actual ingresada no es correcta.']);
        }

        // Save new password
        $user->contraseña = Hash::make($request->input('password'));
        $user->save();

        \App\Helpers\ActivityLogger::log(
            'Configuración',
            'Contraseña Cambiada',
            "El coordinador cambió su contraseña de acceso.",
            'warning'
        );

        return redirect()->route('coordinador.perfil')->with('success', 'Contraseña actualizada correctamente.');
    }
}
