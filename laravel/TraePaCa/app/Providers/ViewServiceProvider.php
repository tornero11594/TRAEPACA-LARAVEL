<?php

namespace App\Providers;

use App\View\Composers\CompanyComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::share('mensaje2', 'Otro mensajillo de prueba');

        //compartir variables a vistas en especifico. En este ejemplo a la vista welcome le pasamos la variable prueba2 con el contenido otro mensajillo... A través del objeto view
        View::composer(['welcome'],CompanyComposer::class);
    }
}
