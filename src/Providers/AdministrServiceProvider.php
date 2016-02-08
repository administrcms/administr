<?php

namespace Administr\Providers;

use Administr\Assets\AssetsFacade;
use Administr\Assets\AssetsServiceProvider;
use Administr\Localization\LocalizeFacade;
use Administr\Localization\LocalizeMiddleware;
use Administr\Localization\LocalizationServiceProvider;
use Administr\Providers\SidebarServiceProvider as AdministrSidebarServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Administr\Form\FormServiceProvider;
use Laracasts\Flash\Flash;
use Laracasts\Flash\FlashServiceProvider;
use Maatwebsite\Sidebar\Middleware\ResolveSidebars;
use Maatwebsite\Sidebar\SidebarServiceProvider;

class AdministrServiceProvider extends ServiceProvider
{

    private $providers = [
        MenuServiceProvider::class,
        RoutesServiceProvider::class,
        FormServiceProvider::class,
        AssetsServiceProvider::class,
        SidebarServiceProvider::class,
        AdministrSidebarServiceProvider::class,
        LocalizationServiceProvider::class,
        FlashServiceProvider::class,
    ];

    private $facades = [
        'Asset'     => AssetsFacade::class,
        'Locale'    => LocalizeFacade::class,
        'Flash'     => Flash::class,
    ];

    private $middleware = [
        ResolveSidebars::class,
        LocalizeMiddleware::class,
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerProviders();
        $this->registerFacades();

        $this->mergeConfigFrom(__DIR__ . '/../Config/administr.php', 'administr');
    }

    public function boot(Kernel $kernel)
    {
        $this->loadViewsFrom(__DIR__ . '/../Views', 'administr');

        $this->loadTranslationsFrom(__DIR__ . '/../Lang', 'administr');

        $this->publishers();

        $this->registerMiddlewares($kernel);

        view()->composer('administr::layout.master', \Administr\ViewComposers\SidebarComposer::class);
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

        $this->publishes([
            __DIR__ . '/../Assets' => public_path('vendor/administr'),
        ], 'public');
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

    private function registerFacades()
    {
        AliasLoader::getInstance($this->facades)->register();
    }
}