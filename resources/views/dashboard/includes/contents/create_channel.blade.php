<!-- 
 # Author     Emeka Osuagwu <emekaosuagwuandela0@gmail.com>
 # Copyright  2015 Emeka Osuagwu
 # License    MIT License <http://opensource.org/licenses/MIT>   
 
 #CodeFuntion: This piece of code is resposible for the structure
 of the create Episode page on the application
 -->

<div class="col s12 m9">

    <div class="row">
        <h4>Create Channel</h4><br>
        <div class="row">
            <form class="col s12">
                
                <div class="row">
                    <div class="input-field col s12">
                        <input placeholder="Channel Title" id="first_name" type="text" class="validate">
                        <label for="first_name">Channel Title</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                    <input disabled. id="disabled" type="text" class="validate">
                    <label for="disabled">Description</label>
                    </div>
                </div><br>

                <div class="row">
                  <div class="file-field input-field">
                        <div class="btn">
                            <span>Upload Cover Image</span>
                            <input type="file" multiple>
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Upload one or more files">
                        </div>
                    </div>
                </div>
                
                <center>
                    <a href="/admin/view_channels" class="waves-effect waves-light btn"><i class="material-icons right"></i>Create</a>
                </center>

            </form>
        </div>
        
    </div>




</div>
