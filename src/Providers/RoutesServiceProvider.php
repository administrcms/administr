<?php

namespace Administr\Providers;

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
     */
    public function boot(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require __DIR__ . '/../routes.php';;
        });

        parent::boot($router);
    }

    public function register()
    {
    }
}