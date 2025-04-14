<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
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
        Route::pattern('id','[0-9]+');

        //configurar que el nombre de las rutas se muestre en español por ejemplo
       // Route::resourceVerbs([
         //   'create' => 'crear',
           // 'edit'=>'editar',
        //]);

        //forma de pasar a todas las vistas una misma variable
        View::share('mensaje','Este es un mensaje de prueba');
    }
}
