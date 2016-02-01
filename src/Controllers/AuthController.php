<?php

namespace Administr\Controllers;

use Administr\Forms\LoginForm;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    /**
     * @var Guard
     */
    private $auth;

    public function __construct(Guard $auth)
    {

        $this->auth = $auth;
    }

    public function getLogin(LoginForm $form)
    {
        return view('administr::users.login', compact('form'));
    }
}