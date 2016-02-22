<?php

namespace Administr\Controllers;


use Administr\Forms\UserForm;
use Administr\Listview\ListView;
use App\Models\User;
use Illuminate\Routing\Controller;

class UsersController extends Controller
{
    public function index(ListView $ls)
    {
        $data = User::all();
        $ls
            ->setDataSource($data)
            ->define(function(ListView $l){
                $l->text('id', 'ID');
                $l->text('email', 'Email');
            });

        return view('administr::users.index', compact('ls'));
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