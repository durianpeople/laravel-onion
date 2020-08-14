<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register view namespaces
        foreach (scandir($path = app_path('Modules')) as $moduleDir) {
            View::addNamespace($moduleDir, "{$path}/{$moduleDir}/Presentation/views");
        }
    }
}
