<div class="col s12 m9">
    <div class="row">
        <h4>Edit Channel</h4><br>
        <div class="row">
            <form id="channel_update" action="/dashboard/channel/edit" method="post">
            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token" />
            <input type="hidden" value="{{ $channels->id }}" name="channel_id" id="channel_id" />
                <div class="row">
                    <div class="input-field col s12">
                        <input value="{{ $channels->channel_name }}" name="channel_name" id="channel_name" type="text">
                        <label for="first_name">Channel Title</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <textarea name="channel_description" class="materialize-textarea" id="channel_description">
                            {{ $channels->channel_description }}
                        </textarea>
                        <label for="description">Episode Description</label>
                    </div>
                </div>
                <input type="submit"  value ="update" class="btn-large" />
            </form>
        </div>
    </div>
</div>
