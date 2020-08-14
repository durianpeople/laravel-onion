<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DependencyInjectionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Global register


        // Modules register
        $this->registerModules();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    private function registerModules()
    {
        $app = $this->app;
        foreach (scandir($path = app_path('Modules')) as $dir) {
            if (file_exists($filepath = "{$path}/{$dir}/dependencies.php")) {
                require $filepath;
            }
        }
    }
}
