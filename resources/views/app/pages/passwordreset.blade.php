@extends('app.authlayout')

@section('title', 'Password Reset')

@section('content')

<div class="row">

    <div class="col s3 hide-on-small-only white-text">
        void
    </div>

    <div class="col s12 m6 l6">

        <div class="center-align fix">

            <h2>Oh Snap!</h2>
            <small>you need a password reset, right?</small>
        </div>

        <div class="row">

            <form class="col s12" id="password_reset_form">
                <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">email</i>
                            <input name="email" id="email" type="email" class="validate" required="true" />
                                <label for="email">Email</label>
                    </div>
                </div>

                <div class="row container">
                    <button type="submit" id="submit_reset" class="waves-effect waves-light btn right">
                        Reset
                    </button>
                </div>

            </form>

        </div>

    </div>

    <div class="col s3 hide-on-small-only white-text">
        void
    </div>

</div>

@endsection
