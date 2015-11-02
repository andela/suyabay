@extends('app.authlayout')

@section('title', 'reset | SuyaBay')

@section('content')

<div class="col s6 m12 l12 spacer">

    <div class="row center-align">

        <h2>Forgot your password?</h2>

    </div>

    <div class="col s6 offset-s3">

        <form id="password_reset_form">

            <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">

            <div class="input-field">
                <i class="material-icons prefix">turned_in_not</i>
                <input id="email" type="email" name="email" class="validate" required>
                <label for="email">Email</label>
            </div>

            <div class="row container">
                <button type="submit" id="submit_reset" class="waves-effect waves-light btn right">
                    Reset
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
