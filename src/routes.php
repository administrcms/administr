<?php

Route::group(['middleware' => ['web']], function(){

    Route::group(['middleware' => 'administr.auth'], function(){
        Route::get('/', [
            'as'    => 'administr.dashboard.index',
            'uses'  => 'DashboardController@index'
        ]);

        Route::get('/language/{code}', [
            'as'    => 'administr.changeLang',
            'uses'  => function($code){
                Localizator::set($code);
                return back();
            }
        ]);
    });
    
    /**
     * Auth routes
     */
    Route::get('auth/login', [
        'as'   => 'administr.auth.login',
        'uses' => 'AuthController@getLogin'
    ]);

    Route::post('auth/login', [
        'as'   => 'administr.auth.login',
        'uses' => 'AuthController@postLogin'
    ]);

    Route::get('auth/logout', [
        'as'   => 'administr.auth.logout',
        'uses' => 'AuthController@getLogout'
    ]);
});