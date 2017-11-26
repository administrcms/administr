<?php

namespace Administr\ViewComposers;

use Administr\AdministrSidebar;
use Illuminate\View\View;
use Maatwebsite\Sidebar\Presentation\SidebarRenderer;

class SidebarComposer
{
    /**
     * @var YourSidebar
     */
    protected $sidebar;

    /**
     * @var SidebarRenderer
     */
    protected $renderer;

    /**
     * @param AdministrSidebar $sidebar
     * @param SidebarRenderer  $renderer
     */
    public function __construct(AdministrSidebar $sidebar, SidebarRenderer $renderer)
    {
        $this->sidebar  = $sidebar;
        $this->renderer = $renderer;
    }

    /**
     * @param $view
     */
    public function compose(View $view)
    {
        $this->sidebar->build();

        $view->with('sidebar', $this->renderer->render(
            $this->sidebar
        ));
    }
}