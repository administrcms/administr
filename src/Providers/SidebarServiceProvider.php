<?php

namespace Administr\Providers;

use Administr\AdministrSidebar;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\Sidebar\SidebarManager;
use Illuminate\Http\Request;

class SidebarServiceProvider extends ServiceProvider
{
    private $request;

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
    }

    public function boot(SidebarManager $manager, Request $request)
    {
        $this->request = $request;

        if (!$this->isBackend())
        {
            return;
        }

        $manager->register(AdministrSidebar::class);
    }

    private function isBackend()
    {
        $url = $this->request->url();
        return str_contains($url, config('administr.prefix'));
    }
}