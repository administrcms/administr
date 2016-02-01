<?php

get('auth/login', [
    'as'   => 'administr.auth.login',
    'uses' => 'AuthController@getLogin'
]);