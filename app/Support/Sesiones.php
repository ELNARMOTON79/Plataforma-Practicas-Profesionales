<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Cierre de sesiones de un usuario. Las sesiones se guardan en la tabla "sessions"
 * (SESSION_DRIVER=database) y la cookie de "Recordarme" depende de remember_token.
 */
class Sesiones
{
    /**
     * Cierra las sesiones del usuario en otros dispositivos y conserva la actual.
     * Úsalo cuando el propio usuario cambia su contraseña.
     */
    public static function cerrarOtras(User $user): void
    {
        DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '!=', session()->getId())
            ->delete();

        // Invalida las cookies de "Recordarme" de los demás dispositivos
        $user->setRememberToken(Str::random(60));
        $user->save();

        // Vuelve a emitir la cookie de "Recordarme" del dispositivo actual con el token nuevo
        $guard = Auth::guard('web');
        if (request()->hasCookie($guard->getRecallerName())) {
            $guard->login($user, true);
        }
    }

    /**
     * Cierra todas las sesiones del usuario (por ejemplo, al desactivarlo o cuando
     * otra persona le restablece la contraseña).
     */
    public static function cerrarTodas(User $user): void
    {
        DB::table('sessions')->where('user_id', $user->id)->delete();

        $user->setRememberToken(Str::random(60));
        $user->save();
    }
}
