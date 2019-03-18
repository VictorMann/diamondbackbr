<?php

namespace App\Providers;

use App\Categoria;
use App\Carrossel;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            [
            'partials.lista-categorias',
            'admin.dashboard',
            'admin.prod_create_update',
            ], 
            function ($view) {
                $view->with('categorias', Categoria::get());
            }
        );

        // carrossel
        view()->composer('partials.carrossel', function($view) {
            $view->with('carrossel', Carrossel::orderBy('order')->get());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
