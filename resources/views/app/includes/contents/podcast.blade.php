<div class="row podcast">
    <div class="col s3">
        <a style="color:#2C3E50" href="/episodes/{{$podcast->id}}">
            <img class="responsive-img podcast-img" src="{!! asset($podcast->image) !!}">
        </a>
    </div>

    <div class="col s9 details">
        <span class="podcast-episode-date">{{$podcast->created_at->diffForHumans()}}</span>
        <span class="tag podcast-episode-date"> <i class="fa fa-headphones fa-lg"></i> {{$podcast->views}}</span>
        <a style="color:#2C3E50" href="/episodes/{{$podcast->id}}">
            <h5 class="podcast-episode-title">{{$podcast->episode_name}}</h5>
        </a>

        @if(Auth::user() || $podcast->allow)
            <div>
                <audio width="10px;" src="{{$podcast->audio_mp3}}" preload="auto" />
            </div>
        @endif

        <p>
             {{$podcast->episode_description}}
        </p>

        <div class="podcast-actions right">

            <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">

            @if( Auth::check() )
                <input type="hidden" id="user_id" value="{{ Auth::user()->id }}" >
            @endif

            <input type="hidden" id="episode_id" value="{{ $podcast->id }}">

            <span style="padding-right:15px;">
                 <i class="fa fa-heart social-btn like-btn {{ $podcast->like_status }}" like-status="{{ $podcast->like_status }}" data-episode-id="{{ $podcast->id }}"></i>
                 <span class="counts"> {{ $podcast->likes }} </span>
            </span>

            <span style="padding-right:15px;">
                <i class="fa fa-comment social-btn like"></i>
                <span class="counts"> {{ $podcast->comment->count() }}</span>
            </span>

            <span style="padding-right:15px;">
                <a href="#" class="twtr-share" data-desc="{{ $podcast->episode_description }}" data-name="{{ $podcast->episode_name }}" data-img="{!! asset($podcast->image) !!}" data-url="{!! url('/episodes', $podcast->id)  !!}">
                    <i class="fa fa-twitter social-btn "></i>
                </a>
            </span>
            <span style="padding-right:15px;">
                <a href="#" class="fb-share" data-desc="{{ $podcast->episode_description }}" data-name="{{ $podcast->episode_name }}" data-img="{!! asset($podcast->image) !!}" data-url="{!! url('/episodes', $podcast->id) !!}">
                    <i class="fa fa-facebook social-btn "></i>
                </a>
            </span>
        </div>

        <div class="left">
            <span class="tag podcast-episode-date" style="position: static;">{{$podcast->channel->channel_name}}</span>
        </div>
    </div>
</div>