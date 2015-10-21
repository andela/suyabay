<!DOCTYPE html>

<html>
    <head>
        <title>@yield('title')</title>

        <!-- View port-->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>

<<<<<<< HEAD
        <!-- HTTP -->
        <script src = "{!! asset('/js/jquery-2.1.1.min.js') !!}"></script>

        <!-- HTTPS -->
        <script src = "{!! secure_asset('/js/jquery-2.1.1.min.js') !!}"></script>

=======
        <script src = "{!! asset('/js/jquery-2.1.1.min.js') !!}"></script>

>>>>>>> d7eb2da9ebc3eb2cc94f8c2fa98699488e21869a

        <!-- Fonts and style rules -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
<<<<<<< HEAD

        <!-- HTTP -->
        <link href="{!! asset('/css/materialize.css') !!}" rel='stylesheet' type="text/css">
        <!-- HTTPS -->
        <link href="{!! secure_asset('/css/materialize.css') !!}" rel='stylesheet' type="text/css">
=======
        <link href="{!! asset('/css/materialize.css') !!}" rel='stylesheet' type="text/css">
>>>>>>> d7eb2da9ebc3eb2cc94f8c2fa98699488e21869a


        <!-- Font Awesome-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">


        <!-- Materialize Compiled and minified JavaScript -->
<<<<<<< HEAD
        <!-- HTTP -->
        <script src = "{!! asset('/js/materialize.min.js') !!}"></script>
        <!-- HTTPS -->
        <script src = "{!! secure_asset('/js/materialize.min.js') !!}"></script>


        <!-- Custom style rules -->
        <link href = "{!! asset('/css/audioplayer.css') !!}" rel="stylesheet"  />
        <link href = "{!! secure_asset('/css/audioplayer.css') !!}" rel="stylesheet"  />

        <link href = "{!! asset('/css/main.css') !!}" rel='stylesheet' type="text/css">
        <link href = "{!! secure_asset('/css/main.css') !!}" rel='stylesheet' type="text/css">

        <!-- Custom js -->
        <script src = "{!! asset('/js/main.js') !!}"></script>
        <script src = "{!! secure_asset('/js/main.js') !!}"></script>

        <script src = "{!! asset('/js/audioplayer.js') !!}"></script>
        <script src = "{!! secure_asset('/js/audioplayer.js') !!}"></script>
=======
        <script src = "{!! asset('/js/materialize.min.js') !!}"></script>

        <!-- Custom style rules -->
        <link href = "{!! asset('/css/main.css') !!}" rel='stylesheet' type="text/css">

        <!-- Custom js -->
        <script src = "{!! asset('/js/main.js') !!}"></script>
>>>>>>> d7eb2da9ebc3eb2cc94f8c2fa98699488e21869a

        <!-- sweetalert -->
        <link rel="stylesheet" type="text/css" href="{!! asset('/library/sweetalert/sweetalert.css') !!}">
        <script type="text/javascript" src="{!! asset('/library/sweetalert/sweetalert.min.js') !!}"></script>

<<<<<<< HEAD
        <!-- Password Reset-->
        <script src = "{!! asset('/js/PasswordReset.js') !!}"></script>
        <script src = "{!! asset('/js/NewPassword.js') !!}"></script>
=======
        <script src = "{!! asset('/js/LoginAndSignup.js') !!}"></script>
>>>>>>> d7eb2da9ebc3eb2cc94f8c2fa98699488e21869a

    </head>
    <body>

<<<<<<< HEAD
        <div class="row">
            @include('app.includes.sections.top_nav')
        </div>

=======
>>>>>>> d7eb2da9ebc3eb2cc94f8c2fa98699488e21869a
        <!-- User Auth -->
        <div class="row">

                @yield('content')

        </div>

        <!-- Footer contents -->

            @include('app.includes.sections.footer')

    </body>
</html>
