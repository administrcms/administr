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
        $this->middleware('auth', ['only' => 'getLogout']);
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->auth = $auth;
    }

    public function getLogin(LoginForm $form)
    {
        return view('administr::auth.login', compact('form'));
    }

    public function postLogin(LoginForm $form)
    {
        $attempt = $this->auth->attempt(
            [
                'email' => $form->email,
                'password' => $form->password,
                'is_active' => true
            ]
        );

        if( !$attempt )
        {
            return back();
        }

        return redirect()->intended(route('administr.dashboard.index'));
    }

    public function getLogout()
    {
        $this->auth->logout();
        return redirect('/');
    }
}