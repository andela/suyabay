<!--
 # Author     Emeka Osuagwu <emekaosuagwuandela0@gmail.com>
 # Copyright  2015 Emeka Osuagwu
 # License    MIT License <http://opensource.org/licenses/MIT>

 #CodeFuntion: This piece of code is resposible for the structure
 of the create Episode page on the application
 -->

<div class="col s12 m9">

    <div class="row">
        <h4>Edit Channel</h4><br>
        <div class="row">
            <form id="channel_update" action="/dashboard/channel/edit" method="post">

                <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token" />
                <input type="hidden" value="{{ $channels->id }}" name="channel_id" id="channel_id" />

                <div class="row">
                    <div class="input-field col s12">
                        <input value="{{ $channels->channel_name }}" name="channel_name" id="channel_name" type="text" class="validate">
                        <label for="first_name">Channel Title</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                    <textarea name="channel_description" id="channel_description">{{ $channels->channel_name }}</textarea>
                    <label for="disabled">Channel Description</label>
                    </div>
                </div><br>

                <center>
                    <button type="submit" class="waves-effect waves-light btn"><i class="material-icons right"></i>Update</button>
                </center>

            </form>
        </div>

    </div>




</div>
