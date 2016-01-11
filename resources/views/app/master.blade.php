<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>

        <!-- View port-->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>

        <!-- HTTP -->
        <script src = "{!! asset('/js/jquery.min.js') !!}"></script>

        <!-- HTTPS -->
        <script src = "{!! secure_asset('/js/jquery.min.js') !!}"></script>


        <!-- Fonts and style rules -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic,800,800italic' rel='stylesheet' type='text/css'>

        <!-- HTTP -->
        <link href="{!! asset('/css/materialize.css') !!}" rel='stylesheet' type="text/css">
        <!-- HTTPS -->
        <link href="{!! secure_asset('/css/materialize.css') !!}" rel='stylesheet' type="text/css">


        <!-- Font Awesome-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">


        <!-- Materialize Compiled and minified JavaScript -->
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
        <script src="{!! asset('/js/audio.min.js') !!}"></script>


    </head>
    <body>
        <!-- top nav -->
        <div class="row">
            @include('app.includes.sections.top_nav')
        </div>

        <!-- main contents -->
        <div class="row">
            @yield('content')
        </div>
        <!-- Footer contents -->
            @include('app.includes.sections.footer')
        <!-- Modal trigger -->
        <script>
            $(document).ready(function() {
                $('.tooltipped').tooltip({delay: 50});
                $('.modal-trigger').leanModal();
                $('.collapsible').collapsible({accordion : true});
            });
        </script>

        <script>
            audiojs.events.ready(function() {
                var as = audiojs.createAll();
                });
        </script>
    </body>
</html>
