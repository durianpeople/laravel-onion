<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
            Blade::componentNamespace("App\\Modules\\{$moduleDir}\\Presentation\\Components", $moduleDir);
        }

        // Timezone for Carbon\Carbon
        date_default_timezone_set('Asia/Aden');
    }
}
