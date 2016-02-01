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
        $this->registerProviders();

        $this->mergeConfigFrom(__DIR__ . '../Config/administr.php', 'administr');
    }

    public function boot(Kernel $kernel)
    {
        $this->loadViewsFrom(__DIR__ . '../Views', 'administr');

        $this->publishers();

        $this->registerMiddlewares($kernel);
    }

    private function publishers()
    {
        $this->publishes([
            __DIR__ . '../Views' => resource_path('views/administr')
        ], 'views');

        $this->publishes([
            __DIR__ . '../Config/administr.php' => config_path('administr.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '../Database/migrations' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__ . '../Database/seeds' => database_path('seeds')
        ], 'seeds');
    }


    private function registerProviders()
    {
        foreach ($this->providers as $provider)
        {
            $this->app->register($provider);
        }
    }
}