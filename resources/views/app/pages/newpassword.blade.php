@extends('app.authlayout')

@section('title', 'New Password')

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

            <form class="col s12" id="new_password_form" action="/password/reset" method="POST">
                {{ csrf_field() }}

                <input type="hidden" name="token" value="{{ $token }}" />

                    @if (count($errors) > 0)
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">email</i>
                            <input name="email" id="email" type="email" value="{{ old('email') }}" class="validate" />
                                <label for="email">Email</label>
                    </div>

                    <div class="input-field col s12">
                        <i class="material-icons prefix">vpn_key</i>
                            <input name="password" id="password" type="password" class="validate" required="true" />
                                <label for="email">New Password</label>
                    </div>

                    <div class="input-field col s12">
                        <i class="material-icons prefix">vpn_key</i>
                            <input name="password_confirmation" id="password_confirmation" type="password" class="validate" required="true" />
                                <label for="email">Confirm Email</label>
                    </div>

                </div>

                <div class="row container">

                    <button type="submit" class="waves-effect waves-light btn right">
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
