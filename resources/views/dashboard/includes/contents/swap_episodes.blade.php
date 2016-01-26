<div class="col s12 m9">
    <div class="row">
        <h4>Swap Episodes from <em><b>{{ $channel->channel_name }}</b></em> to:</h4>
        <div class="row">
            <form class="col s12" id="swap_episodes" action="" method="POST">
                <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" value="{{ $channel->id }}" name="channel_id" id="channel_id">
                <div class="row">
                    <div class="input-field col s12">
                        <select name="new_channel_id" class="spacer" id="new_channel_id">
                            @foreach($channels as $ch)
                            <option value="{{$ch->id}}">{{$ch->channel_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <input type="submit"  value ="swap" class="btn-large" />
            </form>
        </div>
    </div>
</div>
