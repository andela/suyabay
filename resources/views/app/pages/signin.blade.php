@extends('app.authlayout')

@section('title', 'Signin | SuyaBay')

@section('content')

<div class="row">

    <div class="col s3 hide-on-small-only white-text">
        void
    </div>

    <div class="col s12 m6 l6">

        <div class="center-align fix">

            <h2>Signin</h2>
            <small>sign in to your account</small>
        </div>

        <div class="row">

            <form class="col s12">

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">perm_identity</i>
                            <textarea id="icon_prefix1" class="materialize-textarea"></textarea>
                            <label for="icon_prefix1">
                                Username
                            </label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">lock_outline</i>
                            <input id="password" type="password" class="validate">
                                <label for="password">Password</label>
                    </div>
                </div>

                <div class="row container">

                    <p class="left">
                        <input type="checkbox" class="filled-in" id="remember-me" checked="checked" />
                        <label for="remember-me">Remember Me</label>
                    </p>

                    <a class="waves-effect waves-light btn right">
                        Sign In
                    </a>
                </div>
            </form>
        </div>

        <div class="row container">

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

        </div>
    </div>

    <div class="col s3 hide-on-small-only white-text">
        void
    </div>

</div>

@endsection
