@extends('app.authlayout')

@section('title', 'Signup | SuyaBay')

@section('content')

<div class="col s6 m12 spacer">

    <div class="row center-align">
        <h2>Sign up for an account</h2>
    </div>

    <div class="col s6 offset-s3">

        <div class="row">
            <form class="row" action="signup" method="POST">
                <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                <div class="input-field">
                    <i class="material-icons prefix">perm_identity</i>
                        <textarea name="username" id="username" class="materialize-textarea"></textarea>

                <div class="input-field">
                    <i class="material-icons prefix">turned_in_not</i>
                        <input name="email" id="email" type="email" class="validate">
                        <label for="email">Email</label>
                </div>

                <div class="input-field">
                    <i class="material-icons prefix">lock_outline</i>
                    <input name="password" id="password" type="password" class="validate">
                    <label for="password">Password</label>
                </div>

                <div>
                    <p class="left">
                        <input type="checkbox" class="filled-in" id="remember-me" checked="checked" />
                        <label for="remember-me">Remember Me</label>
                    </p>

                    <a class="waves-effect waves-light btn right" onclick="register()">
                        Sign Up
                    </a>
                </div>
            </form>
        </div>

        <div class="row container">

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

        </div>
    </div>
</div>

@endsection
