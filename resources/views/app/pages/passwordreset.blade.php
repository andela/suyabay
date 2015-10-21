@extends('app.authlayout')

<<<<<<< HEAD
@section('title', 'Password Reset | SuyaBay')
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
            <h2>Hollup, hollup!</h2>
            <small>you need a password reset, right?</small>

=======
            <h2>Oh Snap!</h2>
            <small>you need a password reset, right?</small>
>>>>>>> d7eb2da9ebc3eb2cc94f8c2fa98699488e21869a
        </div>

        <div class="row">

<<<<<<< HEAD
            <form class="col s12" id="password_reset_form">
                <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">email</i>
                            <input name="email" id="email" type="email" class="validate" required="true" />

=======
            <form class="col s12">

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">mode_edit</i>
                            <input id="email" type="email" class="validate">
>>>>>>> d7eb2da9ebc3eb2cc94f8c2fa98699488e21869a
                                <label for="email">Email</label>
                    </div>
                </div>

                <div class="row container">
<<<<<<< HEAD
                    <button type="submit" id="submit_reset" class="waves-effect waves-light btn right">
                        Reset
                    </button>
                </div>

            </form>

        </div>

=======

                    <a class="waves-effect waves-light btn right">
                        Reset
                    </a>
                </div>
            </form>
        </div>
>>>>>>> d7eb2da9ebc3eb2cc94f8c2fa98699488e21869a
    </div>

    <div class="col s3 hide-on-small-only white-text">
        void
    </div>

</div>

@endsection
