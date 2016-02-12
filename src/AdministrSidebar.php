<?php

namespace Administr;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Foundation\Application;
use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\ShouldCache;
use Maatwebsite\Sidebar\Sidebar;
use Maatwebsite\Sidebar\Traits\CacheableTrait;

class AdministrSidebar implements Sidebar, ShouldCache
{
    use CacheableTrait;

    /**
     * @var Menu
     */
    private $menu;
    /**
     * @var Application
     */
    private $app;
    /**
     * @var Config
     */
    private $config;

    public function __construct(Menu $menu, Application $app, Config $config)
    {
        $this->menu = $menu;
        $this->app = $app;
        $this->config = $config;
    }

    /**
     * Build your sidebar implementation here
     */
    public function build()
    {
        $this->menu->group(trans('administr::users.management'), function (Group $group) {
            $group->item(trans('administr::users.management'), function (Item $item) {
                $item->weight(0);
                $item->icon('fa fa-users');
                $item->authorize(
                    true
                );
                $item->item(trans('administr::users.users'), function (Item $item) {
                    $item->weight(0);
                    $item->icon('fa fa-users');
                    $item->route('administr.dashboard.index');
                    $item->authorize(
                        true
                    );
                });
                $item->item(trans('administr::roles.roles'), function (Item $item) {
                    $item->weight(1);
                    $item->icon('fa fa-flag-o');
                    $item->route('administr.dashboard.index');
                    $item->authorize(
                        true
                    );
                });
            });
        });

        $sidebars = array_merge(
            $this->config->get('administr.modules'),
            $this->config->get('administr.sidebars')
        );

        foreach ($sidebars as $module) {
            $class = studly_case($module);

            if (!class_exists($class)) {
                $class = "Administr\\{$class}\\SidebarExtender";
            }

            if (!class_exists($class)) {
                continue;
            }

            $extender = $this->app->make($class);
            $this->menu->add(
                $extender->extendWith($this->menu)
            );
        }
    }

    /**
     * @return Menu
     */
    public function getMenu()
    {
        return $this->menu;
    }
}