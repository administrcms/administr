<?php

namespace Administr\Providers;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Administr\Form\FormServiceProvider;
use Maatwebsite\Sidebar\Middleware\ResolveSidebars;
use Maatwebsite\Sidebar\SidebarServiceProvider;

class AdministrServiceProvider extends ServiceProvider
{

    private $providers = [
        MenuServiceProvider::class,
        RoutesServiceProvider::class,
        FormServiceProvider::class,
        SidebarServiceProvider::class,
    ];

    private $middleware = [
        ResolveSidebars::class
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerProviders();

        $this->mergeConfigFrom(__DIR__ . '/../Config/administr.php', 'administr');
    }

    public function boot(Kernel $kernel)
    {
        $this->loadViewsFrom(__DIR__ . '/../Views', 'administr');

        $this->loadTranslationsFrom(__DIR__ . '/../Lang', 'administr');

        $this->publishers();

//        $this->registerMiddlewares($kernel);
    }

    private function publishers()
    {
        $this->publishes([
            __DIR__ . '/../Views' => resource_path('views/administr')
        ], 'views');

        $this->publishes([
            __DIR__ . '/../Config/administr.php' => config_path('administr.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/../Database/migrations' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../Database/seeds' => database_path('seeds')
        ], 'seeds');
    }

    /**
     * @param Kernel $kernel
     */
    private function registerMiddlewares(Kernel $kernel)
    {
        foreach ($this->middleware as $middleware)
        {
            $kernel->pushMiddleware($middleware);
        }
    }

    private function registerProviders()
    {
        foreach ($this->providers as $provider)
        {
            $this->app->register($provider);
        }
    }
}