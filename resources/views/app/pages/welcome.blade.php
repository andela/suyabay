@extends('app.master')

@section('title', 'Welcome | SuyaBay')

@section('content')

<div class="col s12 m6 l12 spacer">
    <div class="row center-align">
        <h2> WELCOME ON BOARD!!!</h2>
        <h3>You are now a {{ $users->role->name }} of our podcast platform</h3>
        <p>You now have access to upload and edit episodes you upload</p>

        @if(! Auth::check())
        <p>Login with your details to enjoy your new access level</p>
        <p>
            <a href="/login" class="waves-effect waves-light btn center">
                log In
            </a>
        </p>
        @endif
    </div>
</div>
@endsection
