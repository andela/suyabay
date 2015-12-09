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
/ Admin User
/-------------------------------------------------------------------------------
*/
    Route::get('/users', [
        'uses' => 'UserController@index',
        'as'   => '/users'
    ]);

    Route::get('/user/{id}/edit', [
        'uses' => 'UserController@editView',
        'as'   => 'user-edit-id'
    ]);

    Route::put('/user/edit', [
        'uses' => 'UserController@update',
        'as'   => 'user-edit'
    ]);

    Route::get('/user/create', [
        'uses' => 'UserController@show',
        'as'   => 'user-create'
    ]);

    Route::post('/user/create', [
        'uses' => 'UserController@createInvite'
    ]);

/*
/-------------------------------------------------------------------------------
/ Admin Channel
/-------------------------------------------------------------------------------
*/
    Route::get('/channels', [
        'uses' => 'ChannelController@index',
        'as'   => '/channels'
    ]);

    Route::get('/channel/{id}/edit', [
        'uses' => 'ChannelController@edit',
        'as'   => 'channel-id-edit'
    ]);
    Route::put('/channel/edit', [
        'uses' => 'ChannelController@update',
        'as'   => '/channel-edit'
    ]);

    Route::get('/channel/create', [
        'uses' => 'ChannelController@createIndex',
        'as'   => '/channel-create'
    ]);
    Route::post('/channel/create', [
        'uses' => 'ChannelController@processCreate'
    ]);
    Route::delete('/channel/{id}', [
        'uses' => 'ChannelController@destroy',
        'as'   => 'channel-id'
    ]);

});

/*
/-------------------------------------------------------------------------------
/ Mail invitation
/-------------------------------------------------------------------------------
*/
Route::get('/invite/{token}', [
    'uses' => 'UserController@processInvite',
    'as'   => 'invite-token'
]);

Route::get('/welcome/{username}', [
    'uses' => 'UserController@welcomePage',
    'as'   => 'welcome-username'
]);

/*
/-------------------------------------------------------------------------------
/ Comment
/-------------------------------------------------------------------------------
*/
Route::post('/comment', [
    'uses' =>'CommentController@postComment',
    'as'   => 'comment'
]);
