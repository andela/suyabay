<!DOCTYPE html>

<html>
    <head>
        <title>@yield('title')</title>

        <!-- View port-->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>

        <script src = "{!! asset('/js/jquery-2.1.1.min.js') !!}"></script>


        <!-- Fonts and style rules -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link href="{!! asset('/css/materialize.css') !!}" rel='stylesheet' type="text/css">


        <!-- Font Awesome-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">


        <!-- Materialize Compiled and minified JavaScript -->
        <script src = "{!! asset('/js/materialize.min.js') !!}"></script>


        <!-- Custom style rules -->
        <link href = "{!! asset('/css/main.css') !!}" rel='stylesheet' type="text/css">

        <!-- Custom js -->
        <script src = "{!! asset('/js/main.js') !!}"></script>

    </head>
    <body>

        <!-- User Auth -->
        <div class="row">

                @yield('content')

        </div>

        <!-- Footer contents -->

            @include('app.includes.sections.footer')

    </body>
</html>
