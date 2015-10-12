@extends('app.authlayout')

@section('title', 'Signup')

@section('content')

<div class="row">

    <div class="col s3 hide-on-small-only white-text">
        void
    </div>

    <div class="col s12 m6 l6">

        <div class="center-align fix">

            <h2>SuyaBay Podcast</h2>
            <small>create your account</small>
        </div>

        <div class="row">

            <form class="col s12">

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">mode_edit</i>
                            <textarea id="icon_prefix1" class="materialize-textarea"></textarea>
                            <label for="icon_prefix1">
                                Username
                            </label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">mode_edit</i>
                            <input id="email" type="email" class="validate">
                                <label for="email">Email</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">mode_edit</i>
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
                    <a href="{{ URL::to('signin') }}"> Sign In to your account</a>
                </small>
            </span>
        </div>
    </div>

    <div class="col s3 hide-on-small-only white-text">
        void
    </div>

</div>

@endsection
