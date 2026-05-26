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

    /**
     * Enviar el enlace de recuperación de contraseña por correo.
     */
    public function enviarEnlaceRecuperacion(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
        ], [
            'correo.required' => 'El correo electrónico es requerido.',
            'correo.email' => 'El formato del correo electrónico es inválido.',
        ]);

        $correo = $request->correo;
        $user = \App\Models\User::where('correo', $correo)->first();

        if (!$user) {
            return back()->withErrors([
                'correo' => 'No pudimos encontrar un usuario registrado con ese correo institucional.'
            ])->onlyInput('correo');
        }

        if (!$user->activo) {
            return back()->withErrors([
                'correo' => 'Esta cuenta se encuentra inactiva. Contacta al administrador.'
            ])->onlyInput('correo');
        }

        // Generar un token único
        $token = \Illuminate\Support\Str::random(60);

        // Guardar token en base de datos
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $correo],
            [
                'token' => $token,
                'created_at' => now()
            ]
        );

        // Enviar el correo
        \Illuminate\Support\Facades\Mail::to($correo)->send(new \App\Mail\RecuperarContrasenaMail($token, $correo));

        // Registrar en la bitácora
        \App\Helpers\ActivityLogger::log(
            'Autenticación',
            'Solicitud de Recuperación',
            "Se envió un correo de restablecimiento de contraseña a la dirección: {$correo}.",
            'info'
        );

        return back()->with('status', '¡Hemos enviado un enlace de recuperación a tu correo institucional!');
    }

    /**
     * Mostrar el formulario para restablecer la contraseña.
     */
    public function mostrarFormularioRestablecer(Request $request, $token)
    {
        $email = $request->query('email');
        
        $record = \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->where('token', $token)
            ->where('email', $email)
            ->first();

        if (!$record) {
            return redirect()->route('recuperar-contrasena')->withErrors([
                'correo' => 'El enlace de recuperación es inválido o ya ha sido utilizado.'
            ]);
        }

        // Comprobar expiración (60 minutos)
        if (\Carbon\Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            \Illuminate\Support\Facades\DB::table('password_reset_tokens')->where('email', $email)->delete();
            return redirect()->route('recuperar-contrasena')->withErrors([
                'correo' => 'El enlace de recuperación ha expirado. Por favor, solicita uno nuevo.'
            ]);
        }

        return view('restablecer_contraseña', [
            'token' => $token,
            'email' => $email
        ]);
    }

    /**
     * Procesar el restablecimiento de la contraseña.
     */
    public function restablecerContrasena(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'correo' => 'required|email',
            'contraseña' => 'required|min:8|confirmed',
        ], [
            'contraseña.required' => 'La nueva contraseña es requerida.',
            'contraseña.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'contraseña.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);

        $record = \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->where('email', $request->correo)
            ->where('token', $request->token)
            ->first();

        if (!$record) {
            return back()->withErrors([
                'correo' => 'El token de restablecimiento es inválido o no corresponde a esta dirección de correo.'
            ]);
        }

        // Comprobar expiración
        if (\Carbon\Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            \Illuminate\Support\Facades\DB::table('password_reset_tokens')->where('email', $request->correo)->delete();
            return redirect()->route('recuperar-contrasena')->withErrors([
                'correo' => 'El enlace de recuperación ha expirado. Por favor, solicita uno nuevo.'
            ]);
        }

        $user = \App\Models\User::where('correo', $request->correo)->first();
        if (!$user) {
            return back()->withErrors([
                'correo' => 'No pudimos encontrar un usuario registrado con ese correo.'
            ]);
        }

        // Actualizar contraseña
        $user->contraseña = \Illuminate\Support\Facades\Hash::make($request->contraseña);
        $user->save();

        // Eliminar token usado
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->where('email', $request->correo)->delete();

        // Registrar en la bitácora
        \App\Helpers\ActivityLogger::log(
            'Autenticación',
            'Restablecimiento de Contraseña',
            "El usuario restableció con éxito su contraseña para la cuenta: {$request->correo}.",
            'success'
        );

        return redirect()->route('login')->with('status', '¡Tu contraseña ha sido restablecida con éxito! Ya puedes iniciar sesión.');
    }
}
