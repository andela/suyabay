<!DOCTYPE html>

<html>
    <head>
        <title>@yield('title')</title>

        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

        <!-- Compiled and minified CSS -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.0/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

         <!-- View port-->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.0/js/materialize.min.js"></script>

        <!-- Custom script here -->
        <script type="text/javascript" src = "{!! asset('/custom/javascript/mai.njs') !!}"></script>

        <style>
            body{
                font-family: Helvetica-neue, sans-serif;
            }
            .title {
                font-size: 56px;
                margin: 0;
                color:#fff;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato' !important;
            }
        </style>

    </head>
    <body>

        <!-- Top Nav -->
        @include('app.includes.sections.top_nav')
        @include('app.includes.sections.modalforms')

        <div class="row">

            <div class="col s3">

                @include('app.includes.sections.side_nav')

            </div>

            <div class="col s9">

                <!-- Main Content -->
                @yield('content')

            </div>
        </div>

        <!-- Footer contents -->
        @include('app.includes.sections.footer')

        <!-- Modal trigger -->
        <script>
            $(document).ready(function(){
                $('.modal-trigger').leanModal();
            });
        </script>
    </body>
</html>
