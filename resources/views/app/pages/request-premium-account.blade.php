@extends('app.master')

@section('title', 'Signup | SuyaBay')

@section('content')

<div class="col s12 m6 l12 spacer">

    <div class="row center-align">
        <h2> Request for a premium account</h2>
    </div>

    <div>
        <form class="form col s6 center offset-s3" action="/signup" method="POST">
            <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
            <div class="input-field">
                <i class="material-icons prefix">turned_in_not</i>
                    <input id="email" name="email" type="email"
                    value="{{ isset($email) ? $email : '' }}" required>
                    <label for="email">Email</label>
            </div>
        </form>
    </div>

    <div class="col s6 center offset-s3">
        <span>
            <small>
                Already a user?
            </small>
        </span>

        <span>
            <small>
                <a href="{{ URL::to('login') }}"> Sign In to your account</a>
            </small>
        </span>

    <div class="col s6 offset-s3">
        <a href="{{ URL::to('login/twitter') }}">
            <div class="twitter">
                <div class="col s3"><i class="fa fa-twitter fa-2x"></i></div>
                <div class="col s9">Login with Twitter</div>
            </div>
        </a>
    </div>
    <!-- end -->
</div>

@endsection
