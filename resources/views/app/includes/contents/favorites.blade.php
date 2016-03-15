<div class="row">

<!-- Side Nav -->

@include('app.includes.sections.sidenav')

    <!-- Feeds Area -->
    <div class="col s12 m8 l9">
        @forelse($userEpisodes as $episodes)
        <!-- start card -->
        <a style="color:#2C3E50" href="/episodes/{{$episodes->id}}">
            <div class="row podcast">
                <div class="col s3">
                    <img class="responsive-img podcast-img" src="{{ asset($episodes->image) }}">
                </div>

                <div class="col s9 details">
                    <span class="podcast-episode-date">{{ $episodes->created_at->diffForHumans() }}</span>
                    <span class="tag podcast-episode-date">{{$episodes->channel->channel_name}}</span>
                    <h5 class="podcast-episode-title">{{ $episodes->episode_name }}</h5>

                    <p>
                        {{$episodes->episode_description}}
                    </p>
                     <div class="podcast-actions">

                    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">

                    @if( Auth::check() )
                        <input type="hidden" id="user_id" value="{{ Auth::user()->id }}" >
                    @endif

                    <input type="hidden" id="episode_id" value="{{ $episodes->first()->id }}">

                    <span style="padding-right:15px;">
                         <i class="fa fa-heart social-btn like-btn {{ $episodes->first()->like_status }}" like-status="{{ $episodes->first()->like_status }}"> {{ $episodes->likes }}</i>
                    </span>

                    <span style="padding-right:15px;">
                        <a href="#" class="twtr-share" data-desc="{{ $episodes->first()->episode_description }}" data-name="{{ $episodes->first()->episode_name }}" data-img="{!! asset($episodes->first()->image) !!}" data-url="{!! url('/episodes', $episodes->first()->id)  !!}">
                            <i class="fa fa-twitter social-btn "></i>
                        </a>
                    </span>
                    <span style="padding-right:15px;">
                        <a href="#" class="fb-share" data-desc="{{ $episodes->first()->episode_description }}" data-name="{{ $episodes->first()->episode_name }}" data-img="{!! asset($episodes->first()->image) !!}" data-url="{!! url('/episodes', $episodes->first()->id) !!}">
                            <i class="fa fa-facebook social-btn "></i>
                        </a>
                    </span>
                </div>

                </div>
            </div>
        </a>
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