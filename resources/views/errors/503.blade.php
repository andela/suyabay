@extends('app.master')

@section('title', 'Oops 404')

@endsection

@section('content')

    <div class="col s12 center-align spacer">
        <div class="error">503</div>
            <div class="error-message">
                Some kinda server error!
            </div>

            <h3 class="error-exit-message">
                Fixing ...
            </h3>

            <br>

            <a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="This way home" href="/">
                <i class="large material-icons">store</i>
            </a>

            <br>
    </div>
@endsection
