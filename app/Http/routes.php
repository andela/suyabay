<?php
/*
|--------------------------------------------------------------------------
| API Routes - Pages
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => '/developer'], function () {
    Route::get('/', [
        'uses' => 'Api\PagesController@index',
        'as'   => 'developer.index',
    ]);
    Route::get('/myapp', [
        'uses'       => 'Api\PagesController@showMyApps',
        'as'         => 'developer.myapp',
        'middleware' => ['auth'],
    ]);
    Route::get('/myapp/new', [
        'uses'       => 'Api\PagesController@createNewApp',
        'as'         => 'developer.new-app',
        'middleware' => ['auth'],
    ]);
    Route::post('/myapp/new/', [
        'uses'       => 'Api\PagesController@postNewAppDetails',
        'as'         => 'developer.create-app',
        'middleware' => ['auth'],
    ]);
    Route::get('/myapp/new-detail', [
        'uses'       => 'Api\PagesController@showNewAppDetails',
        'as'         => 'developer.newapp-details',
        'middleware' => ['auth'],
    ]);
    Route::get('/myapp/{id}', [
        'uses'       => 'Api\PagesController@showAppDetails',
        'as'         => 'developer.app-details',
        'middleware' => ['auth'],
    ]);
    Route::get('/myapp/{id}/delete', [
        'uses'       => 'Api\PagesController@destroy',
        'as'         => 'developer.app-delete',
        'middleware' => ['auth'],
    ]);
    Route::get('/myapp/{id}/edit/', [
        'uses'       => 'Api\PagesController@edit',
        'middleware' => ['auth'],
    ]);
    Route::put('/myapp/edit', [
        'uses'       => 'Api\PagesController@update',
        'as'         => 'developer.app-edit',
        'middleware' => ['auth'],
    ]);
});
/*
|--------------------------------------------------------------------------
| API Routes - Users
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'api/v1/'], function () {
    Route::get('/', function () {
        return json_encode(["message" => "Welcome to Suyabay API"]);
    });
    Route::get('users', [
        'uses' => 'Api\UserController@getAllUsers'
    ]);
    Route::get('users/me', [
        'uses' => 'Api\UserController@getMyDetails'
    ]);
    Route::put('users/me', [
        'uses' => 'Api\UserController@editUser'
    ]);
    Route::patch('users/me', [
        'uses' => 'Api\UserController@editSingleUser'
    ]);
    Route::get('users/{username}', [
        'uses' => 'Api\UserController@getSingleUser'
    ]);
    Route::get('users/{username}/comments', [
        'uses' => 'Api\CommentController@getUserComments'
    ]);
/*
|--------------------------------------------------------------------------
| API Routes - Channels
|--------------------------------------------------------------------------
*/
    Route::get('channels', [
        'uses' => 'Api\ChannelController@getAllChannels'
    ]);
    Route::get('channels/{channel_name}', [
        'uses' => 'Api\ChannelController@getAChannel'
    ]);
    Route::post('channels', [
        'uses' => 'Api\ChannelController@postAChannel'
    ]);
    Route::put('channels/{channel_name}', [
        'uses' => 'Api\ChannelController@editAChannel'
    ]);
    Route::patch('channels/{channel_name}', [
        'uses' => 'Api\ChannelController@editASingleChannelResource'
    ]);
    
    Route::delete('channels/{channel_name}', [
        'uses' => 'Api\ChannelController@deleteASingleChannel'
    ]);
/*
|--------------------------------------------------------------------------
| API Routes - Channel Episodes
|--------------------------------------------------------------------------
*/
    Route::group(['prefix' => 'channels'], function () {
        Route::group(['middleware' => 'premium.user'], function () {
            Route::get('{name}/episodes', [
                'uses' => 'Api\ChannelEpisodesController@getAllEpisodes'
            ]);

            Route::get('{channelName}/episodes/{episodeName}', [
                'uses' => 'Api\ChannelEpisodesController@getAChannelEpisode'
            ]);

            Route::post('{name}/episodes', function () {
                return json_encode(["message" => "post an episode under a channel"]);
            });

            Route::put('{name}/episodes/{episode_id}', function () {
                return json_encode(["message" => "update an episode under a channel"]);
            });

            Route::delete('{channel_id}/episodes/{episode_id}', function () {
                return json_encode(["message" => "delete an episode under a channel"]);
            });
        });
    });
/*
|--------------------------------------------------------------------------
| API Routes - Favourites
|--------------------------------------------------------------------------
*/
    Route::get('users/{username}/favourites', [
        'uses' => 'Api\UserEpisodesLikeController@getUserLikedEpisodes'
    ]);

    Route::delete('users/{username}/favourites', function () {
        return json_encode(["message" => "allow a user to unfavourite an episodes"]);
    });
/*
|--------------------------------------------------------------------------
| API Routes - Episode Comments
|--------------------------------------------------------------------------
*/
    Route::get('episodes/{name}/comments', [
        'uses' => 'Api\CommentController@getEpisodeComments'
     ]);

    Route::get('episodes/{name}/comments/{comment_id}/commenter', [
        'uses' => 'Api\CommentController@getEpisodeCommenter'
    ]);

    Route::delete('episodes/{episode_id}/comments/{comment_id}', function () {
        return json_encode(["message" => "delete a single comment under an episode"]);
    });
});
/*
|--------------------------------------------------------------------------
| Application Routes - Index
|--------------------------------------------------------------------------
*/
Route::get('/', [
    'uses' => 'EpisodeController@index',
    'as' => 'home',
]);

Route::get('/search', [
    'uses' => 'SearchController@getResults',
    'as' => 'searchsuya',
]);

Route::get('/episodes', [
    'uses' => 'EpisodeController@allEpisode',
    'as' => 'home.episodes',
]);

Route::get('/episodes/{id}', [
    'uses' => 'EpisodeController@singleEpisode',
    'as' => 'home.episode.id',
]);

Route::get('/channels', [
    'uses' => 'ChannelController@channelList',
    'as' => 'channels',
]);

Route::get('/channel/{id}', [
    'uses' => 'EpisodeManager@getEpisode',
    'as' => 'episode-show',
]);
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
    'as' => 'passwordreset',
    'middleware' => ['guest'],
]);

Route::get('password/email', [
    'uses' => 'Auth\PasswordController@getEmailPage',
    'as' => 'passwordreset',
]);

Route::post('password/email', [
    'uses' => 'Auth\PasswordController@postEmailForm',
    'as' => 'passwordreset',
]);

// Password reset routes...
Route::get('password/reset/{token}', [
    'uses' => 'Auth\PasswordController@getResetPage',
    'as' => 'passwordresetpage',
]);

// #resetGetEmail
Route::post('password/resetGetEmail', [
    'uses' => 'Auth\PasswordController@postResetCheckEmail',
    'as' => 'postpasswordresetCheckEmail',
]);

/*
/-------------------------------------------------------------------------------
/ Login
/-------------------------------------------------------------------------------
*/
Route::get('login', [
    'uses' => 'Auth\AuthController@login',
    'as' => 'login',
]);

Route::post('login', [
    'uses' => 'Auth\AuthController@postLogin',
    'as' => 'login',
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
    'uses' => 'Auth\AuthController@Register',
    'as' => 'register',
]);

Route::post('signup', [
    'uses' => 'Auth\AuthController@postRegister',
    'as' => 'register',
]);
/*
/-------------------------------------------------------------------------------
/ Search link request
/-------------------------------------------------------------------------------
*/
// Route::post('search', function () {
//     return redirect('/');
// });
/*
/-------------------------------------------------------------------------------
/ Logout
/-------------------------------------------------------------------------------
*/
Route::get('logout', [
    'uses' => 'Auth\AuthController@getLogout',
    'as' => 'logout',
]);
//end
/*
 * Likes
 */
Route::post('/episode/like', [
        'uses' => 'LikeController@postLike',
        'as' => 'episode.like',
    ]);

Route::post('/episode/unlike', [
    'uses' => 'LikeController@postUnlike',
    'as' => 'episode.unlike',
]);
//end
/*
/-------------------------------------------------------------------------------
/ Admin Dashboard Routes
/-------------------------------------------------------------------------------
*/
Route::group(['prefix' => 'dashboard'], function () {
    // Dashboard Homepage
    Route::get('/', [
        'uses' => 'EpisodeManager@stats',
        'as' => 'stats',
        'middleware' => ['auth'],
    ]);
    //end
    // Episode Routes
    Route::get('/episodes', [
        'uses' => 'EpisodeManager@index',
        'as' => 'show.all.episodes',
        'middleware' => ['auth'],
    ]);

    Route::get('episode/create', [
        'uses' => 'EpisodeManager@createEpisode',
        'as' => 'EpisodeCreate',
        'middleware' => ['auth'],
    ]);

    Route::post('episode/create', [
        'uses' => 'EpisodeManager@store',
        'as' => 'create.episode',
        'middleware' => ['auth'],
    ]);

    Route::get('/episode/{id}/edit', [
        'uses' => 'EpisodeManager@edit',
        'middleware' => ['auth'],
    ]);

    Route::put('/episode/edit', [
        'uses' => 'EpisodeManager@update',
        'as' => 'update.episode',
        'middleware' => ['auth'],
    ]);

    Route::patch('/episode/activate', [
        'uses' => 'EpisodeManager@updateEpisodeStatus',
        'as' => 'episode.activate',
    ]);

    Route::get('/episode/{id}/delete', [
        'uses'          => 'EpisodeManager@destroy',
        'as'            => 'destroy.episode',
        'middleware'    => ['auth']
    ]);
    //end
    // User Routes
    Route::get('/users', [
        'uses' => 'UserController@index',
        'as' => 'users',
        'middleware' => ['auth'],
    ]);

    Route::get('/user/{id}/edit', [
        'uses' => 'UserController@editView',
        'as' => 'user-edit-id',
        'middleware' => ['auth'],
    ]);

    Route::put('/user/edit', [
        'uses' => 'UserController@update',
        'as' => 'user-edit',
    ]);

    Route::get('/user/create', [
        'uses' => 'UserController@show',
        'as' => 'user-create',
        'middleware' => ['auth'],
    ]);

    Route::post('/user/create', [
        'uses' => 'UserController@createInvite',
    ]);
    //end
    // Channel Routes
    Route::get('/channels/active', [
        'uses' => 'ChannelController@active',
        'as' => 'active.channels',
        'middleware' => ['auth'],
    ]);

    Route::get('/channels/deleted', [
        'uses' => 'ChannelController@deleted',
        'as' => 'deleted.channels',
        'middleware' => ['auth'],
    ]);

    Route::get('/channels/all', [
        'uses' => 'ChannelController@index',
        'as' => 'all.channels',
        'middleware' => ['auth'],
    ]);

    Route::get('/channel/{id}/edit', [
        'uses' => 'ChannelController@edit',
        'as' => 'channel-id-edit',
        'middleware' => ['auth'],
    ]);

    Route::put('/channel/edit', [
        'uses' => 'ChannelController@update',
        'as' => 'channel-edit',
        'middleware' => ['auth'],
    ]);

    Route::get('/channel/create', [
        'uses' => 'ChannelController@createIndex',
        'as' => 'channel-create',
        'middleware' => ['auth'],
    ]);

    Route::post('/channel/create', [
        'uses' => 'ChannelController@processCreate',
        'as' => 'create.channel',
        'middleware' => ['auth'],
    ]);

    Route::get('/channel/{id}', [
        'uses' => 'ChannelController@showChannel',
        'as' => 'show.channel',
        'middleware' => ['auth'],
    ]);

    Route::delete('/channel/{id}', [
        'uses' => 'ChannelController@destroy',
        'as' => 'delete.channel',
        'middleware' => ['auth'],
    ]);

    Route::put('/channel/{id}', [
        'uses' => 'ChannelController@restore',
        'as' => 'restore.channel',
        'middleware' => ['auth'],
    ]);

    Route::get('/channel/swap/{id}', [
        'uses' => 'ChannelController@swap',
        'as' => 'swap.episodes',
        'middleware' => ['auth'],
    ]);

    Route::post('/channel/swap/{id}', [
        'uses' => 'ChannelController@ProcessSwap',
        'as' => 'swap.episode.to',
        'middleware' => 'auth',
    ]);
    //end
});
/*
/-------------------------------------------------------------------------------
/ Mail invitation
/-------------------------------------------------------------------------------
*/
Route::get('/invite/{token}', [
    'uses' => 'UserController@processInvite',
    'as' => 'invite-token',
]);

Route::get('/welcome/{username}', [
    'uses' => 'UserController@welcomePage',
    'as' => 'welcome-username',
]);
/*
/-------------------------------------------------------------------------------
/ Comment
/-------------------------------------------------------------------------------
*/
Route::post('/comment', [
    'uses' => 'CommentController@postComment',
    'as' => 'comment',
]);

Route::get('/comment', [
    'middleware' => 'auth',
    'uses' => 'CommentController@fetchComment'
]);

Route::delete('comment/{commentId}', [
    'middleware' => 'auth',
    'uses' => 'CommentController@deleteComment'
]);

Route::put('comment/{id}/edit', [
    'middleware' => 'auth',
    'uses' => 'CommentController@editComment'
]);
/*
/-------------------------------------------------------------------------------
/ Update user profile
/-------------------------------------------------------------------------------
*/
Route::get('/favorites', [
    'uses' => 'LikeController@index',
    'as' => 'favorites',
]);

Route::get('/profile/edit', [
    'uses' => 'ProfileController@getProfileSettings',
    'middleware' => ['auth'],
]);

Route::get('/profile/changepassword', [
    'uses' => 'ProfileController@getChangePassword',
    'middleware' => ['auth'],
]);

Route::post('/avatar/setting', [
    'uses' => 'ProfileController@postAvatarSetting',
    'middleware' => ['auth'],
]);

Route::post('/profile/edit', 'ProfileController@updateProfileSettings');
Route::post('/profile/changepassword', 'ProfileController@postChangePassword');
