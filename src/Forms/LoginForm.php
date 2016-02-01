<?php

namespace Administr\Forms;

use Administr\Form\Form;
use Administr\Form\FormBuilder;

class LoginForm extends Form
{

    /**
     * Define the validation rules for the form.
     *
     * @return array
     */
    public function rules()
    {
        // TODO: Implement rules() method.
    }

    /**
     * Define the fields of the form
     *
     * @param FormBuilder $form
     */
    public function form(FormBuilder $form)
    {
        $this->action = route('administr.auth.login');
        $this->method = 'post';

        $form->email('email', trans('administr::users.email'));
        $form->password('password', trans('administr::users.password'));
        $form->submit('login', trans('administr::users.login'));
    }
}