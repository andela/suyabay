<html>
    <head>
    <title>@yield('title')</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.0/css/materialize.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.0/js/materialize.min.js"></script>

    <!-- Custom script here -->
    <script type="text/javascript" src = "{!! asset('/custom/javascripts/init.js') !!}"></script>
    </head>

    <body>

    @include('app.includes.sections.head')

    <!-- Top Nav -->
    @include('app.includes.sections.top_nav')

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

</body>
</html>