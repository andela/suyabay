<!--
 # Author     Emeka Osuagwu <emekaosuagwuandela0@gmail.com>
 # Copyright  2015 Emeka Osuagwu
 # License    MIT License <http://opensource.org/licenses/MIT>

 #CodeFuntion: This piece of code is resposible for the structure
 of the create Episode page on the application
 -->

<div class="col s12 m9">

    <div class="row">

        <h4>Edit User</h4><br>

        <div class="row">
            <form class="col s12" id="edit_user" action="/dashboard/user/edit" method="POST">

                <div class="row">
                    <div class="input-field col s6 ">
                        <input value="{{ $users->username }}" name="username" id="username" placeholder="User Name" id="first_name" type="text" class="validate">
                        <input type="hidden" name="user_id" id="user_id" value="{{ $users->id }}">
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" >
                        <label for="first_name">User Name</label>
                    </div>

                    <div class="input-field col s6">
                        <select class="browser-default" name="user_role" id="user_role">
                            @foreach(  $roles as $role )
                                <option value="{{ $role->id }}"
                                @if( $users->role_id == $role->id )
                                    selected="true"
                                @endif
                                >
                                {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <center>
                    <button type="submit" class="waves-effect waves-light btn"><i class="material-icons left">add</i>Update User</button>
                </center>

            </form>
        </div>

    </div>




</div>
