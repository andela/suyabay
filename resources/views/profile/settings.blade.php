@extends('app.master')

@section('title', 'Edit profile')

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
            <h4>Update Profile</h4><br>
            <div class="row">
                <form id="update_profile" action="/profile/edit" method="POST">
                    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="input-field col s6 ">
                            <input value="{{ $users->username }}" name="username" id="username" placeholder="User Name" id="first_name" type="text" class="validate">
                            <label for="first_name">User Name</label>
                        </div>
                    <center>
                        <button type="submit" class="waves-effect waves-light btn" name="update"><i class="material-icons left">add</i>Update</button>
                    </center>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <form class="col-md-6" method="POST" action="/avatar/setting" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div style="margin: 10px;">
                    <h4>Avatar</h4>
                    <br>
                    <img src="{{ $users->avatar }}" height="125" width="125"/>
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
@endsection