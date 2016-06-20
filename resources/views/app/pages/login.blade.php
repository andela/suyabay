@extends('app.master')

@section('title', 'Signin | SuyaBay')

@section('content')

<div class="col s12 m6 l12 spacer">

    <div class="row center-align">
        <h2>Log in to your account</h2>
    </div>

    <div>
        <form class="col s6 offset-s3">
            <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
            <div class="input-field">
                <i class="material-icons prefix">perm_identity</i>
                <input id="username" type="text" required>
                <label for="icon_prefix1">
                    Username
                </label>
            </div>

            <div class="input-field">
                <i class="material-icons prefix">lock_outline</i>
                <input id="password" type="password" required>
                <label for="password">Password</label>
            </div>

            <div>
                <p class="left">
                    <input type="checkbox" class="filled-in" id="remember-me" checked="checked" />
                    <label for="remember-me">Remember Me</label>
                </p>

                <a class="waves-effect waves-light btn right login-btn">
                    Sign In
                </a>

            </div>
        </form>
    </div>

    <div class="col s6 center offset-s3">
        <span>
            <small>
                Don't have an account?
            </small>
        </span>

        <span>
            <small>
                <a href="{{ URL::to('signup') }}"> Sign Up</a> |
            </small>
        </span>

        <span>
            <small>
                <a href="{{ URL::to('passwordreset') }}"> Forgot password?</a>
            </small>
        </span>
         <h6> OR</h6>
    </div>

        <!-- social login -->
        <div class="col s6 offset-s3">
            <a href="{{ URL::to('facebook') }}">
                <div class="facebook">
                    <div class="col s3"><i class="fa fa-facebook fa-2x"></i></div>
                    <div class="col s9">Login with Facebook</div>
                </div>
            </a>
        </div>

        <div class="col s6 offset-s3">
            <a href="{{ URL::to('twitter') }}">
                <div class="twitter">
                    <div class="col s3"><i class="fa fa-twitter fa-2x"></i></div>
                    <div class="col s9">Login with Twitter</div>
                </div>
            </a>
        </div>

</div>

@endsection
