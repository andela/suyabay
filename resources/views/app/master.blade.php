<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <!-- View port-->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
        <meta name="_token" content="{{ csrf_token() }}" />

        <!-- Fonts and style rules -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic,800,800italic' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" href="{{ load_asset('/images/favicon.ico') }}">

        <!-- Font Awesome-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link href="{!! load_asset('/library/sweetalert/sweetalert.css') !!}" rel="stylesheet"/>
        <link href="{!! load_asset('/css/materialize.css') !!}" rel='stylesheet' type="text/css">

        <!-- Custom style rules -->
        <link href="{!! load_asset('/css/styles.css') !!}" rel='stylesheet' type="text/css">

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

        <script src = "{!! load_asset('/js/jquery.min.js') !!}"></script>
        <!-- Materialize Compiled and minified JavaScript -->
        <script src = "{!! load_asset('/js/materialize.min.js') !!}"></script>
        <script src = "{!! load_asset('/library/sweetalert/sweetalert.min.js') !!}"></script>
        <script src="https://cdn.jsdelivr.net/clipboard.js/1.5.10/clipboard.min.js"></script>
        <script src = "{!! load_asset('/js/scripts.js') !!}"></script>

        @include('sweet::alert')
        
        <script>
            $(document).ready(function() {
                $('select').material_select();
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
