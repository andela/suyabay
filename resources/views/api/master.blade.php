<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>

        <!-- View port-->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>


        <!-- Fonts and style rules -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic,800,800italic' rel='stylesheet' type='text/css'>

        <link href="{!! load_asset('/css/materialize.css') !!}" rel='stylesheet' type="text/css">

        <link rel="shortcut icon" href="{{ load_asset('/images/favicon.ico') }}">

        <!-- Font Awesome-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">


        <script src = "{!! load_asset('/js/jquery.min.js') !!}"></script>

        <!-- Materialize Compiled and minified JavaScript -->
        <script src = "{!! load_asset('/js/materialize.min.js') !!}"></script>

        <!-- Api style sheet -->
        <script src="{!! load_asset('/js/audio.min.js') !!}"></script>
        <script src="{!! load_asset('/js/like.js') !!}"></script>
        <script src = "{!! load_asset('/js/scripts.js') !!}"></script>
        <script src="{!! load_asset('/js/audio.min.js') !!}"></script>
        <script src = "{!! load_asset('/js/comment.js') !!}"></script>

        <script src="{!! load_asset('/js/socialmediashare.js') !!}"></script>
        <script src="{!! load_asset('/js/commentupdate.js') !!}"></script>

        <link href = "{!! load_asset('/library/sweetalert/sweetalert.css') !!}" rel="stylesheet"  />
        <script type="text/javascript" src = "{!! load_asset('/library/sweetalert/sweetalert.min.js') !!}"></script>

        <!-- Custom style rules -->
        <link href = "{!! load_asset('/css/audioplayer.css') !!}" rel="stylesheet"  />

        <link href = "{!! load_asset('/css/api.main.css') !!}" rel='stylesheet' type="text/css">

    </head>
    <body>

        <!-- main contents -->
            @yield('content')
            
        <!-- footer -->
        <div>
            @include("api.includes.sections.footer")
        </div> 
        <script src = "{!! load_asset('/js/scripts.js') !!}"></script>
    </body>
</html>
