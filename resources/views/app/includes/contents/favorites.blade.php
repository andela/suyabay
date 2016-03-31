<div class="row">

<!-- Side Nav -->

@include('app.includes.sections.sidenav')

    <!-- Feeds Area -->
    <div class="col s12 m8 l9">
        @forelse($userEpisodes as $episodes)
        <!-- start card -->
        <div class="row podcast">
            <div class="col s3">
                <a style="color:#2C3E50" href="/episodes/{{$episodes->id}}">
                    <img class="responsive-img podcast-img" src="{!! asset($episodes->image) !!}">
                </a>
            </div>

            <div class="col s9 details">
                <span class="podcast-episode-date">{{$episodes->created_at->diffForHumans()}}</span>
                <span class="tag podcast-episode-date">{{$episodes->channel->channel_name}}</span>
                <a style="color:#2C3E50" href="/episodes/{{$episodes->id}}">
                    <h5 class="podcast-episode-title">{{$episodes->episode_name}}</h5>
                </a>
                <div>
                    <audio width="10px;" src="{{$episodes->audio_mp3}}" preload="auto" />
                </div>
                <p>
                     {{$episodes->episode_description}}
                </p>

                <div class="podcast-actions">

                    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">

                    @if( Auth::check() )
                        <input type="hidden" id="user_id" value="{{ Auth::user()->id }}" >
                    @endif

                    <input type="hidden" id="episode_id" value="{{ $episodes->id }}">

                    <span style="padding-right:15px;">
                         <i class="fa fa-heart social-btn like-btn dislike" like-status="dislike" data-episode-id="{{ $episodes->id }}"> {{ $episodes->likes }}</i>
                    </span>

                    <span style="padding-right:15px;">
                        <i class="fa fa-comment social-btn like"> {{ $episodes->comment->count() }}</i>
                    </span>

                    <span style="padding-right:15px;">
                        <a href="#" class="twtr-share" data-desc="{{ $episodes->episode_description }}" data-name="{{ $episodes->episode_name }}" data-img="{!! asset($episodes->image) !!}" data-url="{!! url('/episodes', $episodes->id)  !!}">
                            <i class="fa fa-twitter social-btn "></i>
                        </a>
                    </span>
                    <span style="padding-right:15px;">
                        <a href="#" class="fb-share" data-desc="{{ $episodes->episode_description }}" data-name="{{ $episodes->episode_name }}" data-img="{!! asset($episodes->image) !!}" data-url="{!! url('/episodes', $episodes->id) !!}">
                            <i class="fa fa-facebook social-btn "></i>
                        </a>
                    </span>
                </div>
            </div>
        </div>
        <!-- end card -->

        @empty
            <p>No favourite episodes to display </p>
        @endforelse

        <!-- Pagination -->
        <div class="row center-align fix">
            <div class="center-align">
                {!! $userEpisodes->render() !!}
            </div>
        </div>
    </div>
</div>