<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
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
    }
}
