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

    public function edit(UserForm $form)
    {
        return view('administer::users.edit', compact('form'));
    }

    public function update(UserForm $form)
    {
        dd($form);
    }

    public function destroy()
    {
        
    }
}