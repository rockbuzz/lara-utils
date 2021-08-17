<?php

namespace Rockbuzz\LaraUtils;

use Illuminate\Support\ServiceProvider as SupportServiceProvider;

class ServiceProvider extends SupportServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/utils.php' => config_path('utils.php')
        ], 'config');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/utils.php', 'utils');
    }
}
