<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\SystemSettings;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Admins are exempt from maintenance mode restrictions
            if ($user->rol_id !== 1) {
                if (SystemSettings::get('maintenance_mode', false)) {
                    Auth::logout();
                    
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    
                    return redirect()->route('login')->with('status', 'El sistema se encuentra temporalmente en mantenimiento. Por favor, intente más tarde.');
                }
            }
        }

        return $next($request);
    }
}
