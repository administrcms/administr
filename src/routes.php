<?php

Route::get('auth/login', [
    'as'   => 'administr.auth.login',
    'uses' => 'AuthController@getLogin'
]);

Route::post('auth/login', [
    'as'   => 'administr.auth.login',
    'uses' => 'AuthController@postLogin'
]);