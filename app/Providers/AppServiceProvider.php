<?php

namespace App\Providers;

use App\Models\Documento;
use App\Models\Solicitud;
use App\Observers\DocumentoObserver;
use App\Observers\SolicitudObserver;
use Illuminate\Support\ServiceProvider;

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
        Solicitud::observe(SolicitudObserver::class);
        Documento::observe(DocumentoObserver::class);
    }
}
