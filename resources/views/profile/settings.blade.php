@extends('app.master')
@section('title', 'Edit profile')
@endsection
@section('content')
<div class="row">
    @include('profile.side_nav')
    <div class="col s12 m9">
        <div class="row">
            <div class="col s12 m4 l8">
                @include('dashboard.includes.sections.alerts')
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6">
            <h4 class="heading">Update Profile</h4>
                <form id="update_profile" action="/profile/edit" method="POST">
                    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="input-field col s12 ">
                            <input value="{{ $users->username }}" name="username" id="username" placeholder="User Name" id="first_name" type="text" class="validate">
                            <label for="first_name">User Name</label>
                        </div>
                        <div class="input-field col s12 ">
                            <button type="submit" class="waves-effect waves-light btn" name="update"><i class="material-icons left">add</i>Update</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col s12 m6 right">
            <h4 class="heading">Update Avatar</h4>
                <form method="POST" action="/avatar/setting" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div style="margin: 10px;">
                        <img src="{{ $users->avatar }}" height="125" width="125"/><br>
                        <input type="file" name="avatar" size="30"></input>
                        <div>
                            <br>
                            <button type="submit" class="btn profile-button form-group button-center" name="upload">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection