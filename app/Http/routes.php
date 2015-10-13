<?php

/*
|--------------------------------------------------------------------------
| Application Routes - Index
|--------------------------------------------------------------------------

*/

Route::get('/', function () {
    return view('app.pages.index');
});


/*
/-------------------------------------------------------------------------------
/ About
/-------------------------------------------------------------------------------
*/

Route::get('about', function () {
    return view('app.pages.about');
});

/*
/-------------------------------------------------------------------------------
/ FAQs
/-------------------------------------------------------------------------------
*/

Route::get('faqs', function () {
    return view('app.pages.faqs');
});

/*
/-------------------------------------------------------------------------------
/ Privacy Policy
/-------------------------------------------------------------------------------
*/

Route::get('privacypolicy', function () {
    return view('app.pages.privacypolicy');
});

Route::get('signin', function () {
    return view('app.pages.signin');
});

Route::get('signup', function () {
    return view('app.pages.signup');
});



// Password reset link request routes...
Route::get('passwordreset', [
    'uses' => 'Auth\PasswordController@passwordPage',
    'as'   => 'passwordreset'
]);

Route::get('password/email', [
    'uses' =>'Auth\PasswordController@getEmail',
    'as'   => "passwordreset"
]);
Route::post('password/email', [
    'uses' => 'Auth\PasswordController@checkEmail',
    'as'   => 'passwordreset'
]);
// Route::post('password/email', [
//     'uses' => 'Auth\PasswordController@postEmail',
//     'as'   => 'passwordreset'
// ]);

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');