<?php

namespace App\Providers;

use App\Modules\Shared\Mechanism\ModuleTranslator;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\FileLoader;

class ModuleTranslationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            ModuleTranslator::class,
            function (Application $app) {
                $loader = new FileLoader($app->get('files'), '');

                foreach (scandir($path = app_path('Modules')) as $module) {
                    $loader->addNamespace($module, "{$path}/{$module}/Presentation/lang");
                }

                $translator = new ModuleTranslator($loader);

                $translator->setFallback(Config::get('fallback_locale'));

                return $translator;
            }
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
