<?php

/*
|--------------------------------------------------------------------------
| Application Routes - Index
|--------------------------------------------------------------------------

*/

Route::get('/', [
    'uses' => 'IndexController@index',
    'as'   => 'home'
]);

Route::get('/', 'EpisodeController@index');

/*
/-------------------------------------------------------------------------------
/ About
/-------------------------------------------------------------------------------
*/

Route::get('about', 'PagesController@about');

/*
/-------------------------------------------------------------------------------
/ FAQs
/-------------------------------------------------------------------------------
*/

Route::get('faqs', 'PagesController@faqs');

/*
/-------------------------------------------------------------------------------
/ Privacy Policy
/-------------------------------------------------------------------------------
*/

Route::get('privacypolicy', 'PagesController@privacypolicy');

/*
/-------------------------------------------------------------------------------
/ Password reset link request
/-------------------------------------------------------------------------------
*/

Route::get('passwordreset', [
    'uses' => 'Auth\PasswordController@passwordPage',
    'as'   => 'passwordreset'
]);

Route::get('password/email', [
    'uses' =>'Auth\PasswordController@getEmailPage',
    'as'   => "passwordreset"
]);

Route::post('password/email', [
    'uses' => 'Auth\PasswordController@postEmailForm',
    'as'   => 'passwordreset'
]);

// Password reset routes...
Route::get('password/reset/{token}', [
    'uses' =>'Auth\PasswordController@getResetPage',
    'as'   => 'passwordresetpage'
]);

// #resetGetEmail
Route::post('password/resetGetEmail', [
    'uses' => 'Auth\PasswordController@postResetCheckEmail',
    'as'   => 'postpasswordresetCheckEmail'
]);

/*
/-------------------------------------------------------------------------------
/ Login
/-------------------------------------------------------------------------------
*/

Route::get('login', [
    'uses' => 'Auth\AuthController@login',
    'as'   => 'login'
]);

Route::post('login', [
    'uses' => 'Auth\AuthController@postLogin',
    'as'   => 'login'
]);

/*
/-------------------------------------------------------------------------------
/ Social Authentication
/-------------------------------------------------------------------------------
*/

Route::get('/login/{provider}', 'OauthController@getSocialRedirect');

/*
/-------------------------------------------------------------------------------
/ Register
/-------------------------------------------------------------------------------
*/

Route::get('signup', [
    'uses' =>'Auth\AuthController@Register',
    'as'   => 'register'
]);

Route::post('signup', [
    'uses' =>'Auth\AuthController@postRegister',
    'as'   => 'register'
]);

/*
/-------------------------------------------------------------------------------
/ Search link request
/-------------------------------------------------------------------------------
*/
Route::post('search', function(){
    return redirect('/');
});


/*
/-------------------------------------------------------------------------------
/ Logout
/-------------------------------------------------------------------------------
*/

Route::get('logout', [
    'uses'  => 'Auth\AuthController@getLogout',
    'as'    => 'logout'
]);

/*
/-------------------------------------------------------------------------------
/ Admin
/-------------------------------------------------------------------------------
*/

Route::group(['prefix' => 'dashboard'], function () {

    Route::get('/', function () {
        return view('dashboard.pages.index');
    });

    Route::get('/users', [
        'uses' => 'AdminUserController@index',
        'as'   => '/users'
    ]);

    Route::get('/user/edit', function () {
        return view('dashboard.pages.edit_user');
    });

    Route::get('/user/create', function () {
        return view('dashboard.pages.create_user');
    });

    Route::get('/episodes', function () {
        return view('dashboard.pages.view_episodes');
    });

    Route::get('/episode/create', function () {
        return view('dashboard.pages.create_episode');
    });

    Route::get('/episode/edit', function () {
        return view('dashboard.pages.edit_episode');
    });

/*
/-------------------------------------------------------------------------------
/ Admin Channel
/-------------------------------------------------------------------------------
*/
    Route::get('/channels', [
        'uses' => 'ChannelController@index',
        'as'   => '/channels'
    ]);

    Route::get('/channel/edit/{id}', [
        'uses' => 'ChannelController@edit',
        'as'   => '/channel/channel/edit/{id}'
    ]);
    Route::post('/channel/edit', [
        'uses' => 'ChannelController@update',
        'as'   => '/channel/edit'
    ]);

    Route::get('/channel/create', [
        'uses' => 'ChannelController@createIndex',
        'as'   => '/channel/channel'
    ]);
    Route::post('/channel/create', [
        'uses' => 'ChannelController@processCreate',
        'as'   => '/channel/channel'
    ]);
    Route::post('/channel/delete/{id}', [
        'uses' => 'ChannelController@destroy',
        'as'   => '/channel/delete/{id}'
    ]);

});
