@extends('app.master')

@section('title', 'Page not found')

@section('content')

    <div class="col s12 center-align">
        <div class="error">404</div>
            <div class="error-message">
                Yikes! Well, angry looking aliens came and took this page away, but
            </div>

            <h3 class="error-exit-message">
                we are so sorry!
            </h3>

            <br>

            <a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="This way home" href="/">
                <i class="large material-icons">store</i>
            </a>

            <br>

    </div>
@endsection
