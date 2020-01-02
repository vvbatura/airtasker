<?php

Route::group(['namespace' => 'Api'], function () {
    Route::get('/test-sms', 'AuthController@TestSms');
    Route::get('/location/get-geo', 'LocationController@getFromGEO');

    Route::group(['prefix' => 'auth'], function () {

        Route::post('/register', 'AuthController@register');
        Route::post('/login', 'AuthController@login');
        Route::post('/verify', 'AuthController@verify');
        Route::get('/login/{provider}', 'AuthProviderController@redirectToProvider');
        Route::get('/{provider}/callback', 'AuthProviderController@handleProviderCallback');

        Route::group(['middleware' => 'jwt'], function() {

            Route::get('/refresh', 'AuthController@refresh');
            Route::post('/logout', 'AuthController@logout');
            Route::post('/me', 'AuthController@me');

        });

        Route::post('/forgot-password-email', 'AuthController@forgotPasswordEmail');
        Route::post('/forgot-password-phone', 'AuthController@forgotPasswordPhone');
        Route::post('/check-token', 'AuthController@checkTokenEmail');
        Route::post('/reset-password', 'AuthController@resetPassword');
    });

    //Route::group(['middleware' => 'jwt'], function() {

        Route::group(['prefix' => 'category'], function () {
            Route::get('/', 'CategoryController@index');
            Route::get('/{category}', 'CategoryController@show');
            Route::post('/', 'CategoryController@store');
            Route::put('/{category}', 'CategoryController@update');
            Route::delete('/{category}', 'CategoryController@delete');
            Route::delete('/', 'CategoryController@deleteMany');
        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('/', 'UserController@index');
            Route::get('/{user}', 'UserController@show');
            Route::get('/{user}/skills', 'UserController@showSkills');
            Route::get('/{user}/notification', 'UserController@showNotifications');
            Route::put('/{user}', 'UserController@update');
            Route::patch('/{user}/avatar', 'UserController@saveAvatar');
            Route::patch('/{user}/resume', 'UserController@saveResume');
            Route::patch('/{user}/portfolio', 'UserController@savePortfolio');
            Route::put('/{user}/skills', 'UserController@saveSkills');
            Route::patch('/{user}/notification/{notification}', 'UserController@saveNotification');
            Route::patch('/{user}/password', 'UserController@savePassword');
            Route::delete('/{user}', 'UserController@delete');
            Route::delete('/', 'UserController@deleteMany');
        });

        Route::group(['prefix' => 'notification'], function () {
            Route::get('/', 'NotificationController@index');
        });
    //});


});
