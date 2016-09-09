<?php

namespace Administr\Providers;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class RoutesServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Administr\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param Router|\Illuminate\Routing\Router $router
     * @param Repository $config
     */
    public function boot(Router $router, Repository $config)
    {
        $router->group(['namespace' => $this->namespace, 'prefix' => $config->get('administr.prefix')], function ($router) {
            require __DIR__ . '/../routes.php';;
        });
    }

    public function register()
    {
    }
}