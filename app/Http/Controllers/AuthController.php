<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'correo' => ['required', 'email'],
            'contraseña' => ['required'],
        ]);

        // Mapping the 'contraseña' input field to Laravel's expected 'password' key 
        // for Auth::attempt if the user provider uses it, but our User model has getAuthPasswordName() returning 'contraseña'.
        // Laravel's EloquentUserProvider will extract the credential by the name defined in getAuthPasswordName() 
        // OR we just use 'password' key in the array and Laravel maps it to getAuthPasswordName internally.
        // Actually, Auth::attempt uses 'password' key to check the hashed password.
        if (Auth::attempt(['correo' => $credentials['correo'], 'password' => $credentials['contraseña']], $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            if (!$user->activo) {
                \App\Helpers\ActivityLogger::log('Autenticación', 'Inicio de Sesión Bloqueado', "Intento de inicio de sesión fallido para la cuenta inactiva: {$credentials['correo']}.", 'warning');
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors([
                    'correo' => 'Esta cuenta se encuentra inactiva.',
                ])->onlyInput('correo');
            }

            \App\Helpers\ActivityLogger::log('Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', 'success');

            // Redirect based on role
            $roleRoutes = [
                1 => 'admin.dashboard',
                2 => 'coordinador.dashboard',
                3 => 'estudiante.dashboard',
                4 => 'empresa.dashboard',
            ];

            $route = $roleRoutes[$user->rol_id] ?? 'login';

            return redirect()->route($route);
        }

        \App\Helpers\ActivityLogger::log('Autenticación', 'Inicio de Sesión Fallido', "Intento de inicio de sesión fallido para la cuenta: {$credentials['correo']}.", 'danger');

        return back()->withErrors([
            'correo' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('correo');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            \App\Helpers\ActivityLogger::log('Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', 'info');
        }
        
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
