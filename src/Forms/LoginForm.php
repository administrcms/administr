<?php

namespace Administr\Forms;

use Administr\Form\Form;
use Administr\Form\FormBuilder;

class LoginForm extends Form
{
    /**
     * Define the fields of the form
     *
     * @param FormBuilder $form
     */
    public function form(FormBuilder $form)
    {
        $this->action = route('administr.auth.login');
        $this->method = 'post';

        $form->email('email', trans('administr::users.email'))
            ->password('password', trans('administr::users.password'))
            ->submit('login', trans('administr::users.login'));
    }

    /**
     * Define the validation rules for the form.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password'  => 'required|min:6'
        ];
    }
}