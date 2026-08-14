<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Estudiante;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['estudiante.*', 'layouts.estudiante'], function ($view) {
            if (Auth::check() && Auth::user()->rol_id == 3) {
                $user = Auth::user();
                $estudiante = Estudiante::where('usuario_id', $user->id)->first();

                $nombre = $estudiante?->nombre_completo ?? Str::before($user->correo, '@');
                $matricula = $estudiante?->matricula ?? '—';
                $carrera = $estudiante?->carrera ?? '—';
                
                $partes = preg_split('/\s+/', trim($nombre)) ?: [];
                $iniciales = collect($partes)
                    ->filter()
                    ->take(2)
                    ->map(fn ($p) => Str::upper(Str::substr($p, 0, 1)))
                    ->implode('');
                
                $iniciales = $iniciales !== '' ? $iniciales : 'E';

                $view->with([
                    'nombre' => $nombre,
                    'matricula' => $matricula,
                    'carrera' => $carrera,
                    'iniciales' => $iniciales,
                    'estudianteApp' => $estudiante, 
                ]);
            }
        });
    }
}
