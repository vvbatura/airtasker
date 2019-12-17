<?php

Route::group(['namespace' => 'Api'], function () {
    Route::get('/test-sms', 'AuthController@TestSms');
    Route::get('/location/get-geo', 'LocationController@getFromGEO');

    Route::group(['prefix' => 'auth'], function () {

        Route::post('/register', 'AuthController@register');
        Route::post('/login', 'AuthController@login');
        Route::get('/verify', 'AuthController@verify');
        Route::get('/login/{provider}', 'AuthProviderController@redirectToProvider');
        Route::get('/{provider}/callback', 'AuthProviderController@handleProviderCallback');

        Route::group(['middleware' => 'jwt'], function() {

            Route::get('/refresh', 'AuthController@refresh');
            Route::post('/logout', 'AuthController@logout');
            Route::post('/me', 'AuthController@me');

        });

        Route::post('/forgot-password-email', 'AuthController@forgotPasswordEmail');
        Route::post('/forgot-password-phone', 'AuthController@forgotPasswordPhone');
        Route::post('/reset-password-email', 'AuthController@resetPasswordEmail');
        Route::post('/reset-password-phone', 'AuthController@resetPasswordPhone');
    });

    Route::group(['middleware' => 'jwt'], function() {

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
            Route::put('/{user}', 'UserController@update');
            Route::patch('/{user}/image', 'UserController@saveImage');
            Route::patch('/{user}/skills', 'UserController@saveSkills');
            Route::patch('/{user}/password', 'UserController@savePassword');
            Route::delete('/{user}', 'UserController@delete');
            Route::delete('/', 'UserController@deleteMany');
        });

    });

    /*Route::group(['middleware' => 'jwt'], function() {

        Route::get('/countries', 'CountryController');
        Route::get('/categories', 'CategoryController');
        Route::get('/cities', 'CityController');
        Route::get('/experiences', 'ExperienceController');
        Route::resource('/vacancies', 'VacancyController');
        Route::put('/users', 'UserController@update')->middleware('jwt');
        Route::post('/users/password', 'UserController@changePassword')->middleware('jwt');

        Route::get('/profiles', 'ProfileController@show');
        Route::put('/profiles/{profile}', 'ProfileController@update');

    });*/


});
