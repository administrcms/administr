<?php

namespace Administr\Providers;

use Illuminate\Support\ServiceProvider;

class AdministrServiceProvider extends ServiceProvider
{

    private $providers = [
        MenuServiceProvider::class,
        RoutesServiceProvider::class,
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        foreach($this->providers as $provider)
        {
            $this->app->register($provider);
        }
    }
}