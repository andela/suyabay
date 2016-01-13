@extends('dashboard.master')

@section('title', 'This is SuyaBay #TISb')

@endsection

@section('content')
<div class="col s12 m9">

    <div class="row">

        <h4>Update Profile</h4><br>

        <div class="row">
            <form class="col s12" id="edit_user" action="/dashboard/user/edit" method="POST">

                <div class="row">
                    <div class="input-field col s6 ">
                        <input value="{{ $users->username }}" name="username" id="username" placeholder="User Name" id="first_name" type="text" class="validate">
                        <input type="hidden" name="user_id" id="user_id" value="{{ $users->id }}">
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" >
                        <label for="first_name">User Name</label>
                    </div>
                </div>

                <center>
                    <button type="submit" class="waves-effect waves-light btn"><i class="material-icons left">add</i>Update User</button>
                </center>

            </form>
        </div>
    </div>
</div>



@endsection
