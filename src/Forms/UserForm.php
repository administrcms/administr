<?php

namespace Administr\Forms;


use Administr\Form\Form;
use Administr\Form\FormBuilder;

class UserForm extends Form
{
    /**
     * Define the validation rules for the form.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6',
        ];
    }

    /**
     * Define the fields of the form
     *
     * @param FormBuilder $form
     */
    public function form(FormBuilder $form)
    {
        $form->action = route('administr.users.update');
        $form->method = 'put';

        $form
            ->email('email', 'Email address')
            ->password('password', 'Password')
            ->submit('update', 'Update user');
    }
}