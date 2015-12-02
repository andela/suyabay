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
            <form class="col s12">
                <div class="row">
                    <div class="input-field col s6 ">
                        <input value="{{ $users->username }}" placeholder="User Name" id="first_name" type="text" class="validate">
                        <label for="first_name">User Name</label>
                    </div>

                    <div class="input-field col s6">
                        <select class="browser-default">
                            <option value=""  selected>Select User Role </option>
                            <option value="1">Super Admin</option>
                            <option value="1">Super Admin</option>
                        </select>
                    </div>
                </div>

                <center>
                    <a href="/dashboard/users" class="waves-effect waves-light btn"><i class="material-icons left">add</i>Update User</a>
                </center>

            </form>
        </div>

    </div>




</div>
