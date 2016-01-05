@extends('app.master')

@section('title', 'Access Denied')

@endsection

@section('content')

    <div class="col s12 center-align">
        <div class="error">404</div>
            <div class="error-message">
                Yikes! Well, angry looking aliens came and took this page away, but
            </div>

            <h3 class="error-exit-message">
                Access denied,<br /> you do not have access to view this page!!!
            </h3>

            <br>

            <a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="This way home" href="/">
                <i class="large material-icons">store</i>
            </a>

            <br>

    </div>
@endsection
