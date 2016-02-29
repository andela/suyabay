@extends('app.authlayout')

@section('title', 'Change Password')

@section('content')

<div class="row">

    <div class="col s12 m9 hide-on-small-only white-text">
        void
    </div>

    <div class="col s12 m6 l6">

        <div class="center-align fix">
            @include('dashboard.includes.sections.alerts')
            <h2>Change Password</h2>
            <small>Enter your new password</small>

        </div>

        <div class="row">

            <form class="col s12" id="change_password_form" action="/profile/changepassword" method="POST">
            {!! csrf_field() !!}


                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">vpn_key</i>
                            <input name="old_password" id="password" type="password" class="validate" required="true" />
                                <label for="email">Old Password</label>
                    </div>

                    <div class="input-field col s12">
                        <i class="material-icons prefix">vpn_key</i>
                            <input name="password" id="password" type="password" class="validate" required="true" />
                                <label for="email">New Password</label>
                    </div>

                    <div class="input-field col s12">
                        <i class="material-icons prefix">vpn_key</i>
                            <input name="password_confirmation" id="password_confirmation" type="password" class="validate" required="true" />
                                <label for="email">Confirm Password</label>
                    </div>
                </div>

                <div class="row container">

                    <button type="submit" name="submit" class="waves-effect waves-light btn right">
                        Change password
                    </button>

                </div>

            </form>

        </div>

    </div>

    <div class="col s12 m9 hide-on-small-only white-text">
        void
    </div>

</div>

@endsection
