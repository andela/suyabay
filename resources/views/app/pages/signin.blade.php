@extends('app.authlayout')

@section('title', 'Signin')

@section('content')

<div class="row">

    <div class="col s3 hide-on-small-only white-text">
        void
    </div>

    <div class="col s12 m6 l6">

        <div class="center-align fix">

            <h2>SuyaBay Podcast</h2>
            <small>sign in to your account</small>
        </div>

        <div class="row">

            <form class="col s12" method="POST" action="{{ route('login') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">mode_edit</i>
                            <textarea name="username" id="icon_prefix1" class="materialize-textarea"></textarea>
                            <label for="icon_prefix1">
                                Username
                            </label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">mode_edit</i>
                            <input name="password" id="password" type="password" class="validate">
                                <label for="password">Password</label>
                    </div>
                </div>

                <div class="row container">

                    <p class="left">
                        <input type="checkbox" class="filled-in" id="remember-me" checked="checked" />
                        <label for="remember-me">Remember Me</label>
                    </p>

                    <button class="waves-effect waves-light btn right">
                        Sign In
                    </button>
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
