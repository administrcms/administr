<?php

namespace Administr\Controllers;


use Administr\Forms\UserForm;
use Illuminate\Routing\Controller;

class UsersController extends Controller
{
    public function index()
    {
        return view('administr::users.index');
    }

    public function edit(UserForm $form, $id)
    {
        $form->action = route('administr.users.update', [$id]);
        $form->method = 'put';

        return view('administr::users.edit', compact('form'));
    }

    public function update(UserForm $form)
    {
        dd($form);
    }

    public function destroy()
    {

    }
}