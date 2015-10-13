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

Route::get('passwordreset', function () {
    return view('app.pages.passwordreset');
});