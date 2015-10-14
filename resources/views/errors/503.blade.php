@extends('app.master')

@section('title', 'Oops 404')

@endsection

@section('content')

    <div class="col s12 center-align">
        <div class="error">503</div>
            <div class="error-message">
                Some kinda server error!
            </div>

            <h3 class="error-exit-message">
                Fixing ...
            </h3>

    </div>
@endsection
