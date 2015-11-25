<!-- 
 # Author     Emeka Osuagwu <emekaosuagwuandela0@gmail.com>
 # Copyright  2015 Emeka Osuagwu
 # License    MIT License <http://opensource.org/licenses/MIT>   
 
 #CodeFuntion: This piece of code is resposible for the structure
 of the create Episode page on the application
 -->

<div class="col s12 m9">

    <div class="row">
        
        <h4>Create User</h4><br>

        <div class="row">
            <form class="col s12">
                <div class="row">
                    <div class="input-field col s6 ">
                        <input placeholder="User Name" id="first_name" type="text" class="validate">
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

                <div class="row">
                  <div class="file-field input-field">
                        <div class="btn">
                            <span>Upload Avater</span>
                            <input type="file" multiple>
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Upload one or more files">
                        </div>
                    </div>
                </div>
                
                <center>
                    <a class="waves-effect waves-light btn" onclick="registerUser()"><i class="material-icons left">add</i>Create User</a>
                </center>
            
            </form>
        </div>
        
    </div>




</div>
