var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

    /**
     * Merge all suyabay js files into scripts.js in public/js
     *
     * run gulp --production to minify
     */
    mix.scripts([
        'admin.js',
        'audio.min.js',
        'audioplayer.js',
        'comment.js',
        'commentupdate.js',
        'dashboard.js',
        'like.js',
        'loginAndSignup.js',
        'main.js',
        'NewPassword.js',
        'PasswordReset.js',
        'socialmediashare.js'
    ], 'public/js/scripts.js', 'public/js');

    /**
     * Compile sass files to css
     */
    mix.sass('main.scss')
       .sass('audioplayer.scss');

    /**
     * Merge css files into styles.css in public/css
     */
    mix.styles([
        'audioplayer.css',
        'main.css'
    ], 'public/css/styles.css', 'public/css');
});
