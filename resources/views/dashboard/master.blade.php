<!DOCTYPE html>

<html>
    <head>
        <title>@yield('title')</title>

        <!-- View port-->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>

        <!-- HTTP -->
        <script src = "{!! load_asset('/js/jquery.min.js') !!}"></script>        
        

        <link href="{!! load_asset('/library/sweetalert/sweetalert.css') !!}" rel='stylesheet' type="text/css">
        <script src = "{!! load_asset('/library/sweetalert/sweetalert.min.js') !!}"></script>

        <!-- Fonts and style rules -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic,800,800italic' rel='stylesheet' type='text/css'>

        <!-- HTTP -->
        <link href="{!! load_asset('/css/materialize.css') !!}" rel='stylesheet' type="text/css">
        

        <link href = "{!! load_asset('/css/main.css') !!}" rel='stylesheet' type="text/css">
        

        <!-- Font Awesome-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">


        <!-- Materialize Compiled and minified JavaScript -->
        <!-- HTTP -->
        <script src = "{!! load_asset('/js/materialize.min.js') !!}"></script>    


        <script src = "{!! load_asset('/js/dashboard.js') !!}"></script>

        <link href = "{!! load_asset('/css/dashboard.css') !!}" rel='stylesheet' type="text/css">


    </head>
    <body>

        <div class="row">
            @include('app.includes.sections.top_nav')
        </div>

        <div class="row">
            @include('dashboard.includes.sections.side_nav')

            @yield('content')
        </div>


        <script>
            
  $(document).ready(function() {
    $('select').material_select();
  });
            
        </script>

    </body>
</html>



