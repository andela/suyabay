@extends('app.master')

@section('title', 'User not authorized')

@endsection

@section('content')

    <div class="col s12 center-align">
        <div class="error">401</div>
            <div class="error-message">
                Yikes! Well, you are not authorized to view this page
            </div>

            <h3 class="error-exit-message">
                we are so sorry!
            </h3>

            <br>

            <a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="This way home" href="/">
                <i class="large material-icons">info</i>
            </a>

            <br>

    </div>
@endsection
