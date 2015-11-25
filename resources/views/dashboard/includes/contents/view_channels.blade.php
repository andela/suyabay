<div class="col s12 m9">
    <div class="row">
        @foreach($channels as $channel)
        <div class="card col s5 m4 episode-item z-depth-1">
            <div class="card-image waves-effect waves-block waves-light">
                <img class="activator" src="{{ asset('images/image.png') }}">
            </div>

            <div class="">
                <span class="card-title activator grey-text text-darken-4">{{ $channel->channel_name }}</span><br>
                <span class=" activator grey-text text-darken-4 episode-icon"><i class="fa fa-heart">{{ $channel->subscription_count }}</i></span>
                <span class=" activator grey-text text-darken-4 episode-icon"><i class="fa fa-volume-up"> {{ $channel->episodes->count() }}</i></span>
            </div>

            <div class="card-reveal">
                <span class="card-title grey-text text-darken-4">{{ $channel->channel_name }}<i class="material-icons right">close</i></span>
                <p>{{ $channel->channel_description }}</p>
                <a href="/dashboard/channel/edit/{{ $channel->id }}" class="waves-effect waves-light btn">Edit</a>
                <a class="waves-effect waves-light btn delete_channel" data-name="{{ $channel->channel_name }}" data-id="{{ $channel->id }}" data-token="{{ csrf_token() }}">Delete</a>
            </div>
            <br>
        </div>
    @endforeach

    </div>
</div>