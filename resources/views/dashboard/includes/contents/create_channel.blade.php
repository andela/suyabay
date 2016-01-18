<div class="col s12 m9">

    <div class="row">
        <h4>Create Channel</h4><br>
        <div class="row">
            <form class="col s12" id="create_channel" action="/dashboard/channel/create" method="post">
                <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token" />

                <div class="row">
                    <div class="input-field col s12">
                        <input placeholder="Channel Title" name="name" id="name" type="text" class="validate" require="true">
                        <label for="name">Channel Title</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                    <textarea id="description" name="description" placeholder="Channel Description" require="true"></textarea>
                    <label for="description">Channel Description</label>
                    </div>
                </div><br>

                <center>
                    <button type="submit" class="waves-effect waves-light btn"><i class="material-icons right"></i>Create</button>
                </center>

            </form>
        </div>

    </div>

</div>
