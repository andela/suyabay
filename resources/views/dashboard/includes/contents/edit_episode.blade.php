<div class="col s12 m9">
    <div class="row">
        <h4>Edit Episode</h4><br>
        <div class="row">
            <form class="col s12" id="episode_update" action="#" method="POST">
                <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" value="{{ $episode->id }}" name="episode_id" id="episode_id">
                <div class="row">
                    <div class="input-field col s6">
                        <input value="{{ $episode->episode_name }}" name="episode" id="episode" type="text" require="true">
                        <label for="episode">Episode Title</label>
                    </div>
                    <div class="input-field col s6">
                        <select name="channel_id" id="channel_id">
                            @foreach($channels as $ch)
                            <option value="{{$ch->id}}" name="channel_id">{{$ch->channel_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="{{ $episode->episode_description }}" name="description" id="description" type="text" require="true">
                        <label for="description">Episode Description</label>
                    </div>
                </div>
                <input type="submit"  value ="update" class="btn-large" />
            </form>
        </div>
    </div>
</div>
