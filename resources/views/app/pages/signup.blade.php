@extends('app.authlayout')

@section('title', 'Signup | SuyaBay')

@section('content')

<div class="col s12 m6 l12 spacer">

    <div class="row center-align">
        <h2> Sign up for an account</h2>
    </div>

    <div>
        <form class="form col s6 center offset-s3" action="signup" method="POST">
            <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
            <div class="input-field">
                <i class="material-icons prefix">perm_identity</i>
                <textarea id="username" class="materialize-textarea" required="required"></textarea>
                <label for="icon_prefix1">
                    Username
                </label>
            </div>

            <div class="input-field">
                <i class="material-icons prefix">turned_in_not</i>
                    <input id="email" type="email" class="validate" required="required">
                    <label for="email">Email</label>
            </div>

            <div class="input-field">
                <i class="material-icons prefix">lock_outline</i>
                    <input id="password" type="password" class="validate" required="required">
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
        <h6> OR</h6>
    </div>

    <!-- social login -->

    <div class="col s6 offset-s3">
        <div class="facebook">
            <div class="col s3"><i class="fa fa-facebook fa-2x"></i></div>
            <div class="col s9">Login with Facebook</div>
        </div>
    </div>
    <div class="col s6 offset-s3">
        <div class="twitter">
            <div class="col s3"><i class="fa fa-twitter fa-2x"></i></div>
            <div class="col s9">Login with Twitter</div>
        </div>
    </div>
    <!-- end -->
</div>

@endsection
