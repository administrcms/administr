<?php

namespace Administr\ListViews;

use Administr\ListView\Columns\Action;
use Administr\ListView\ListView;

class UsersListView extends ListView
{
    public function __construct($dataSource = null)
    {
        parent::__construct($dataSource);

        $this->class = 'table table-bordered table-hover';
    }

    protected function columns()
    {
        $this
            ->text('id', '#')
            ->text('name', 'Name')
            ->text('email', 'Email')
            ;
    }

    protected function actions()
    {
        $this
            ->action('edit', '')
            ->define(function(Action $action, array $row) {
                $action->icon('fa fa-edit');
                $action->url(route('administr.users.edit', [$row['id']]));
            });
    }
}