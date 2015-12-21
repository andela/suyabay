<div class="col s12 m9">

    <div class="row">
        @include('dashboard.includes.sections.alerts')
        <h4>Edit Episode</h4><br>

        <div class="row">

            <form class="col s12" action="{{ route('episode.update', $episode->id )}}" method="POST"
            enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token" />
                <div class="row">
                    <div class="input-field col s6">
                        <input value="{!! $episode->episode_name !!}" name="title" type="text">
                        <label for="title">Episode Title</label>
                    </div>

                    <div class="input-field col s6">
                         <select name="channel">
                            @foreach($channels as $channel)
                                <option value="{{$channel->id}}" name="channel">{{$channel->channel_name}}
                                </option>
                            @endforeach
                        </select>
                        <label for="channel">Channel Name</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                    <textarea name="description" class="materialize-textarea">
                        {!! $episode->episode_description !!}
                    </textarea>
                    <label for="description">Episode Description</label>
                    </div>
                </div>
                <input type="submit"  value ="update" class="btn-large" />
            </form>
        </div>
    </div>
</div>
