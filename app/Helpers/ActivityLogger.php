<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActivityLogger
{
    /**
     * Write an action to the activity log.
     *
     * @param string $module
     * @param string $action
     * @param string $description
     * @param string $level (success, info, warning, danger)
     * @param array|object|string|null $payload
     * @return void
     */
    public static function log(string $module, string $action, string $description, string $level = 'info', $payload = null): void
    {
        try {
            $ip = request()->ip() ?? '127.0.0.1';
            $userAgent = request()->userAgent() ?? '';
            
            $user = Auth::user();
            
            $userName = 'Sistema';
            $userRole = 'Sistema';
            $userEmail = 'system@ucol.mx';
            
            if ($user) {
                $userEmail = $user->correo;
                
                // Map role IDs to role names
                $roles = [
                    1 => 'Administrador',
                    2 => 'Coordinador',
                    3 => 'Alumno',
                    4 => 'Empresa',
                ];
                $userRole = $roles[$user->rol_id] ?? 'Usuario';
                
                // Fetch full name based on role relationship
                if ($user->rol_id == 1 || $user->rol_id == 2) {
                    $userName = $user->coordinador->nombre_completo ?? $user->correo;
                } elseif ($user->rol_id == 3) {
                    $userName = $user->alumno->nombre_completo ?? $user->correo;
                } elseif ($user->rol_id == 4) {
                    $userName = $user->empresa->nombre_empresa ?? $user->correo;
                } else {
                    $userName = $user->correo;
                }
            }
            
            // Map severity level to friendly name
            $levelNames = [
                'success' => 'Éxito',
                'info'    => 'Info',
                'warning' => 'Advertencia',
                'danger'  => 'Error',
            ];
            $levelName = $levelNames[strtolower($level)] ?? 'Info';

            // Insert into the database
            DB::table('bitacora')->insert([
                'timestamp'   => now(),
                'level'       => $level,
                'level_name'  => $levelName,
                'user'        => $userName,
                'user_role'   => $userRole,
                'user_email'  => $userEmail,
                'module'      => $module,
                'action'      => $action,
                'description' => $description,
                'ip'          => $ip,
                'user_agent'  => $userAgent,
                'payload'     => $payload ? (is_string($payload) ? $payload : json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) : null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        } catch (\Exception $e) {
            // Silence logging errors to prevent breaking critical user flows, or log to standard Laravel log
            \Log::error('Error logging to bitacora: ' . $e->getMessage());
        }
    }
}
