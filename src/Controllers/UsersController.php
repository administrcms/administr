<?php

namespace Administr\Controllers;

use Administr\Forms\UserForm;
use Administr\ListView\ListView;
use Administr\ListViews\UsersListView;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UsersController extends AdminController
{
    /**
     * Get a configured instance of the ListView for the resource.
     *
     * @param array $args
     * @return ListView
     */
    public function getListView(array $args = [])
    {
        return new UsersListView(
            User::paginate(20)
        );
    }

    /**
     * Get the action URL for storing data.
     *
     * @param array $args
     * @return string
     */
    public function getStoreAction(array $args = [])
    {
        return null;
    }

    /**
     * Get the action URL for updating data.
     *
     * @param array $args
     * @return string
     */
    public function getUpdateAction(array $args = [])
    {
        list($id) = $args;
        return route('administr.users.edit', [$id]);
    }

    /**
     * Get an instance of the model for a record.
     *
     * @param array $args
     * @return Model
     */
    public function getModel(array $args)
    {
        return User::class;
    }

    public function update($id, UserForm $form)
    {
        $user = User::find($id);

        $user->update($form->all());

        return redirect()->route('administr.users.index');
    }
}