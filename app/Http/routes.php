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
    'as'   => 'passwordreset',
    'middleware'   => ['guest']
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

    // Route::get('/', function () {
    //     return view('dashboard.pages.index');
    // });

    Route::get('/', [
        'uses' => 'EpisodeManager@index',
        'as' => 'dashboard/'
    ]);

    Route::get('/users', function () {
        return view('dashboard.pages.user');
    });

    Route::get('/user/edit', function () {
        return view('dashboard.pages.edit_user');
    });

    Route::get('/user/create', function () {
        return view('dashboard.pages.create_user');

    });

    //Episodes Routes
    Route::get('episode/create', 'EpisodeManager@showIndex');

    Route::get('episode/create', 'EpisodeManager@showChannelsForCreate');

    Route::post('episode/create', 'EpisodeManager@store');

    Route::get('/episodes', 'EpisodeManager@index');

    Route::get('/episode/{id}/edit', 'EpisodeManager@edit');

    Route::get('/episode/{id}/delete', 'EpisodeManager@destroy');

    Route::put('/episode/{id}/edit', [
        'uses'  => 'EpisodeManager@update',
        'as'    => 'episode.update',
        'middleware'   => ['auth']
    ]);



    Route::patch('/episode/activate', [
        'uses' => 'EpisodeManager@updateEpisodeStatus',
        'as' => 'episode.activate'
    ]);
    //end

    Route::delete('/episode/{id}', [
        'uses' => 'EpisodeManager@destroy',
        'as'   => 'episode.delete'
    ]);


/*
/-------------------------------------------------------------------------------
/ Admin User
/-------------------------------------------------------------------------------
*/
    Route::get('/users', [
        'uses' => 'UserController@index',
        'as'   => 'users',
        'middleware'   => ['auth']
    ]);

    Route::get('/user/{id}/edit', [
        'uses' => 'UserController@editView',
        'as'   => 'user-edit-id',
        'middleware'   => ['auth']
    ]);

    Route::put('/user/edit', [
        'uses' => 'UserController@update',
        'as'   => 'user-edit'
    ]);

    Route::get('/user/create', [
        'uses' => 'UserController@show',
        'as'   => 'user-create',
        'middleware'   => ['auth']
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
        'as'   => 'channels',
        'middleware'   => ['auth']
    ]);

    Route::get('/channel/{id}/edit', [
        'uses' => 'ChannelController@edit',
        'as'   => 'channel-id-edit',
        'middleware'   => ['auth']
    ]);
    Route::put('/channel/edit', [
        'uses' => 'ChannelController@update',
        'as'   => 'channel-edit'
    ]);

    Route::get('/channel/create', [
        'uses' => 'ChannelController@createIndex',
        'as'   => 'channel-create',
        'middleware'   => ['auth']
    ]);
    Route::post('/channel/create', [
        'uses' => 'ChannelController@processCreate',
        'as' => 'create.channel'
    ]);
    Route::delete('/channel/{id}', [
        'uses' => 'ChannelController@destroy',
        'as'   => 'channel-id'
    ]);
    Route::get('/channel/{id}', [
        'uses' => 'ChannelController@showChannel',
        'as'   => 'channel-show',
        'middleware'   => ['auth']
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

Route::get('/dashboard/episode/pending', [
    'uses' =>'EpisodeManager@pendingEpisode',
    'as'   => 'comment'
]);
