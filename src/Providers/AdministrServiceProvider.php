<?php

namespace Administr\Providers;

use Administr\Assets\AssetsFacade;
use Administr\Assets\AssetsServiceProvider;
use Administr\Commands\MakeAdmin;
use Administr\Commands\MakeAdminController;
use Administr\ListView\ListViewServiceProvider;
use Administr\Localization\LocalizationFacade;
use Administr\Localization\Middleware\LocalizationMiddleware;
use Administr\Localization\LocalizationServiceProvider;
use Administr\Providers\SidebarServiceProvider as AdministrSidebarServiceProvider;
use Administr\QueryFilters\QueryFiltersServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Administr\Form\FormServiceProvider;
use Laracasts\Flash\Flash;
use Laracasts\Flash\FlashServiceProvider;
use Maatwebsite\Sidebar\Middleware\ResolveSidebars;
use Maatwebsite\Sidebar\SidebarServiceProvider;
use Administr\Localization\Middleware\AdminAuth;

class AdministrServiceProvider extends ServiceProvider
{

    private $providers = [
        RoutesServiceProvider::class,
        FormServiceProvider::class,
        AssetsServiceProvider::class,
        SidebarServiceProvider::class,
        AdministrSidebarServiceProvider::class,
        LocalizationServiceProvider::class,
        FlashServiceProvider::class,
        ListViewServiceProvider::class,
        QueryFiltersServiceProvider::class,
    ];

    private $facades = [
        'Asset'         => AssetsFacade::class,
        'Localizator'   => LocalizationFacade::class,
        'Flash'         => Flash::class,
    ];

    private $commands = [
        MakeAdminController::class,
        MakeAdmin::class,
    ];

    private $middleware = [
        \Illuminate\Session\Middleware\StartSession::class,
        ResolveSidebars::class,
    ];

    private $routeMiddleware = [
        'administr.auth'        => AdminAuth::class,
        'administr.localized'   => LocalizationMiddleware::class,
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

        $this->commands($this->commands);

        $this->mergeConfigFrom(__DIR__ . '/../Config/administr.php', 'administr');
    }

    public function boot(Kernel $kernel, Router $router)
    {
        $this->loadViewsFrom(__DIR__ . '/../Views', 'administr');

        $this->loadTranslationsFrom(__DIR__ . '/../Lang', 'administr');

        $this->publishers();

        $this->registerMiddlewares($kernel);
        $this->registerRouteMiddlewares($router);

        view()->composer('administr::layout.master', \Administr\ViewComposers\SidebarComposer::class);
        view()->composer('administr::layout.master', \Administr\ViewComposers\LanguageComposer::class);
    }

    private function publishers()
    {
        $this->publishes([
            __DIR__ . '/../Views' => resource_path('views/vendor/administr')
        ], 'views');

        $this->publishes([
            __DIR__ . '/../Config/administr.php' => config_path('administr.php')
        ], 'config');

//        $this->publishes([
//            __DIR__ . '/../Database/migrations' => database_path('migrations')
//        ], 'migrations');

//        $this->publishes([
//            __DIR__ . '/../Database/seeds' => database_path('seeds')
//        ], 'seeds');

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

    private function registerRouteMiddlewares(Router $router)
    {
        foreach($this->routeMiddleware as $key => $middleware)
        {
            $router->aliasMiddleware($key, $middleware);
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