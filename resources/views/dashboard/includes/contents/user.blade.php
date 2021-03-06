<div class="col s12 m9">
    <div class="row">

        <div class="col m12">
            <a href="/dashboard/user/create" class="waves-effect waves-light btn btn-small"><i class="material-icons">add</i></a>
        </div>

        @foreach($users as $user)
        <div class="card col m3">
            <div class="card-image waves-effect waves-block waves-light user-profile-image">
                <img width="150" height="150" class="activator user-avater " src="{{ $user->getAvatar() }}" onerror="this.src='http://www.gravatar.com/avatar/\'.md5(strtolower(trim($user->email))).\'?d=mm&s=500'">
            </div>

            <div class="card-content center-align">
                <span class="user-name activator grey-text text-darken-4">{{ $user->username }}</span>
                <p><a href="#">{{ $user->role->name }}</a></p>
                <a href="/dashboard/user/{{ $user->id }}/edit" class="btn">Edit Profile</a>
            </div>
        </div>
        @endforeach

        <div class="col s12">
            {!! $users->render() !!}
        </div>
    </div>
</div>