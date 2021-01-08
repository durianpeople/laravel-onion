<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AssetPublishingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $published = collect([]);
        foreach (scandir($path = app_path('Modules')) as $moduleDir) {
            if ($moduleDir == '.' || $moduleDir == '..') {
                continue;
            }

            $snake_module = Str::snake($moduleDir);

            $asset_path = app_path("Modules/{$moduleDir}/Presentation/assets");
            if (!file_exists($asset_path)) {
                continue;
            }

            $published->push(
                [
                    $asset_path => public_path("assets/{$snake_module}"),
                ]
            );
        }

        $this->publishes(
            $published->collapse()->all(),
            'public'
        );
    }
}
