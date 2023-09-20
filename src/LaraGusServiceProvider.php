<?php

namespace xGrz\LaraGus;

use Illuminate\Support\ServiceProvider;

class LaraGusServiceProvider extends ServiceProvider
{
   public function register(): void
    {
    }

    public function boot(): void
    {
        $this->publishes([__DIR__ . '/../config/config.php' => config_path('laragus.php')]);

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }

}
