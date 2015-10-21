@extends('app.authlayout')

<<<<<<< HEAD
@section('title', 'Signup | SuyaBay')
=======
@section('title', 'Signup')
>>>>>>> d7eb2da9ebc3eb2cc94f8c2fa98699488e21869a

@section('content')

<div class="row">

    <div class="col s3 hide-on-small-only white-text">
        void
    </div>

    <div class="col s12 m6 l6">

        <div class="center-align fix">

<<<<<<< HEAD
            <h2>Signup</h2>
=======
            <h2>SuyaBay Podcast</h2>
>>>>>>> d7eb2da9ebc3eb2cc94f8c2fa98699488e21869a
            <small>create your account</small>
        </div>

        <div class="row">
<<<<<<< HEAD

            <form class="col s12">

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">perm_identity</i>
                            <textarea id="icon_prefix1" class="materialize-textarea"></textarea>
=======
        
            <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">mode_edit</i>
                            <textarea id="username" class="materialize-textarea"></textarea>
>>>>>>> d7eb2da9ebc3eb2cc94f8c2fa98699488e21869a
                            <label for="icon_prefix1">
                                Username
                            </label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
<<<<<<< HEAD
                        <i class="material-icons prefix">turned_in_not</i>
=======
                        <i class="material-icons prefix">mode_edit</i>
>>>>>>> d7eb2da9ebc3eb2cc94f8c2fa98699488e21869a
                            <input id="email" type="email" class="validate">
                                <label for="email">Email</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
<<<<<<< HEAD
                        <i class="material-icons prefix">lock_outline</i>
=======
                        <i class="material-icons prefix">mode_edit</i>
>>>>>>> d7eb2da9ebc3eb2cc94f8c2fa98699488e21869a
                            <input id="password" type="password" class="validate">
                                <label for="password">Password</label>
                    </div>
                </div>

                <div class="row container">

                    <p class="left">
                        <input type="checkbox" class="filled-in" id="remember-me" checked="checked" />
                        <label for="remember-me">Remember Me</label>
                    </p>

<<<<<<< HEAD
                    <a class="waves-effect waves-light btn right">
                        Sign Up
                    </a>
                </div>
            </form>
=======
                    <button class="waves-effect waves-light btn right" onclick="register()">
                        Sign Up
                    </button>
                </div>
            
>>>>>>> d7eb2da9ebc3eb2cc94f8c2fa98699488e21869a
        </div>

        <div class="row container">

            <span>
                <small>
                    Already a user?
                </small>
            </span>

            <span>
                <small>
<<<<<<< HEAD
                    <a href="{{ URL::to('signin') }}"> Sign In to your account</a>
=======
                    <a href="{{ URL::to('login') }}"> Sign In to your account</a>
>>>>>>> d7eb2da9ebc3eb2cc94f8c2fa98699488e21869a
                </small>
            </span>
        </div>
    </div>

    <div class="col s3 hide-on-small-only white-text">
        void
    </div>

</div>

@endsection
<<<<<<< HEAD
=======

>>>>>>> d7eb2da9ebc3eb2cc94f8c2fa98699488e21869a
