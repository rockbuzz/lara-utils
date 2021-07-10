<?php

namespace Rockbuzz\LaraUtils;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider as SupportServiceProvider;

class ServiceProvider extends SupportServiceProvider
{

    public function boot(Filesystem $filesystem)
    {
        $this->publishes([
            __DIR__ . '/../config/utils.php' => config_path('utils.php')
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/utils.php', 'utils');
    }
}
