@extends('app.master')
@section('title', 'Request Premium Account | SuyaBay')
@section('content')
<div class="row">
    <div class="col m6 s12 offset-m3">
        <h3> Request for a premium account </h3>
        @include('dashboard.includes.sections.alerts')
        <form class="form"  action="/dashboard/upgrade-account" method="POST">
            <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
            <div class="input-field col s12">
                <input value="" name="email" id="email" placeholder="Email" id="email" type="text" class="validate">
                <label for="email">Email</label>
            </div>
            <div class="input-field col s12">
                <textarea class="materialize-textarea" name="reason"></textarea>
                <label for="reason">Reason</label>
            </div>
            <div class="input-field col s12">
                <button type="submit" class="waves-effect waves-light btn left" name="send"><i class="material-icons left">send</i>Send</button>
            </div>
        </form>
    </div>
</div>
@endsection