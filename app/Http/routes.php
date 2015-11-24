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

Route::get('dashboard', function ()
{
    return view('dashboard.pages.index');
});

Route::get('dashboard/user', function ()
{
    return view('dashboard.pages.user');
});

Route::get('dashboard/edit_user', function ()
{
    return view('dashboard.pages.edit_user');
});

Route::get('dashboard/create_episode', function ()
{
    return view('dashboard.pages.create_episode');
});

Route::get('dashboard/view_episodes', function ()
{
    return view('dashboard.pages.view_episodes');
});

Route::get('dashboard/edit_episode', function ()
{
    return view('dashboard.pages.edit_episode');
});

Route::get('dashboard/create_channel', function ()
{
    return view('dashboard.pages.create_channel');
});

Route::get('dashboard/view_channels', function ()
{
    return view('dashboard.pages.view_channels');
});

Route::get('dashboard/edit_channel', function ()
{
    return view('dashboard.pages.edit_channel');
});

Route::get('dashboard/create_user', function ()
{
    return view('dashboard.pages.create_user');
});
