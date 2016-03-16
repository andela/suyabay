<div class="row">

<!-- Side Nav -->
     @include('app.includes.sections.sidenav')

    <!-- Feeds Area -->
    <div class="col s12 m8 l9">

        <h4 class="center-align padcast-page-header" style="margin-bottom:50px;">Podcast for Suya lovers</h1>

        @foreach($episodes as $podcast)
        <a style="color:#2C3E50" href="/episodes/{{$podcast->id}}">
            <div class="row podcast">
            <div class="col s3">
                <a style="color:#2C3E50" href="/episodes/{{$podcast->id}}">
                    <img class="responsive-img podcast-img" src="{!! asset($podcast->image) !!}">
                </a>
            </div>

            <div class="col s9 details">
                <span class="podcast-episode-date">{{$podcast->created_at->diffForHumans()}}</span>
                <span class="tag podcast-episode-date">{{$podcast->channel->channel_name}}</span>
                <a style="color:#2C3E50" href="/episodes/{{$podcast->id}}">
                    <h5 class="podcast-episode-title">{{$podcast->episode_name}}</h5>
                </a>
                <div>
                    <audio width="10px;" src="{{$podcast->audio_mp3}}" preload="auto" />
                </div>
                <p>
                     {{$podcast->episode_description}}
                </p>

                <div class="podcast-actions">

                    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">

                    @if( Auth::check() )
                        <input type="hidden" id="user_id" value="{{ Auth::user()->id }}" >
                    @endif

                    <input type="hidden" id="episode_id" value="{{ $podcast->id }}">

                    <span style="padding-right:15px;">
                         <i class="fa fa-heart social-btn like-btn {{ $podcast->like_status }}" like-status="{{ $podcast->like_status }}"> {{ $podcast->likes }}</i>
                    </span>

                    <span style="padding-right:15px;">
                        <i class="fa fa-comment social-btn like"> {{ $podcast->comment->count() }}</i>
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
            </div>
        </div>
        </a>
        @endforeach

        <p class="center-align">
            <a href="/" class=" waves-effect waves-light btn">Back home</a>
        </p>
    </div>
</div>
