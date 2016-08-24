<?php

namespace NotificationChannels\PanaceaMobile;

use Illuminate\Support\ServiceProvider;

class PanaceaMobileServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PanaceaMobileApi::class, function ($app) {
            $config = config('services.panaceamobile');

            return new PanaceaMobileApi($config['login'], $config['secret'], $config['sender']);
        });
    }
}
