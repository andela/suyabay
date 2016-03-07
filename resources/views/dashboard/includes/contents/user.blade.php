<div class="col s12 m9">
    <div class="row">

        <div class="col m12">
            <a href="/dashboard/user/create" class="waves-effect waves-light btn btn-small"><i class="material-icons">add</i></a>
        </div>

        @foreach($users as $user)
        <div class="card col m3">
            <div class="card-image waves-effect waves-block waves-light">
                <img style="border-radius: 360px;" class="activator user-avater " src="{{ $user->getAvatar() }}">
            </div>

            <div class="card-content center-align">
                <span class="user-name activator grey-text text-darken-4">{{ $user->username }}</span>
                <p><a href="#">{{ $user->role->name }}</a></p>
                <a href="/dashboard/user/{{ $user->id }}/edit" class="btn">Edit Profile</a>
            </div>
        </div>
        @endforeach

    </div>
</div>