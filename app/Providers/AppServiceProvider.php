<?php

namespace App\Providers;

use App\Categoria;
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
        view()->composer(['partials.lista-categorias', 'admin.prod_create_update'], function ($view) {
            $view->with('categorias', Categoria::get());
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
