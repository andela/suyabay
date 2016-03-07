<div class="row">

<!-- Side Nav -->

    @include('app.includes.sections.sidenav')

    <!-- Feeds Area -->

    @if($episodes->count() > 0 )
        <div class="col s12 m8 l9">
               
            <h4 class="center-align padcast-page-header" style="margin-bottom:50px;">Podcast for Suya lovers</h1>

           <div class="row podcast">
                <div class="col s3">
                    <a style="color:#2C3E50" href="/episodes/{{$episodes->first()->id}}">
                        <img class="responsive-img podcast-img" src="{!! asset($episodes->first()->image) !!}">
                    </a>
                </div>

                <div class="col s9 details">
                    <span class="podcast-episode-date">{{$episodes->first()->created_at->diffForHumans()}}</span>
                    <span class="tag podcast-episode-date">{{$episodes->first()->channel->channel_name}}</span>
                    <a style="color:#2C3E50" href="/episodes/{{$episodes->first()->id}}">
                        <h5 class="podcast-episode-title">{{$episodes->first()->episode_name}}</h5>
                    </a>
                    <div>
                        <audio width="10px;" src="{{$episodes->first()->audio_mp3}}" preload="auto" />
                    </div>
                    <p>
                         {{$episodes->first()->episode_description}}
                    </p>

                    <div class="podcast-actions">

                        <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                        
                        @if( Auth::check() )
                            <input type="hidden" id="user_id" value="{{ Auth::user()->id }}" >
                        @endif         

                        <input type="hidden" id="episode_id" value="{{ $episodes->first()->id }}">
                        
                        <span style="padding-right:15px;">
                             <i class="fa fa-heart social-btn like-btn {{ $episodes->first()->like_status }}" like-status="{{ $episodes->first()->like_status }}"> {{ $episodes->first()->likes }}</i>
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
            
            @foreach($episodes->take(4) as $podcast)
            <a style="color:#2C3E50" href="/episodes/{{$podcast->id}}">
                <div class="row podcast">
                    <div class="col s3">
                        <img class="responsive-img podcast-img" src="{{ asset($podcast->image) }}">
                    </div>

                    <div class="col s9 details">
                        <span class="podcast-episode-date">{{ $podcast->created_at->diffForHumans() }}</span>
                        <span class="tag podcast-episode-date">{{$podcast->channel->channel_name}}</span>
                        <h5 class="podcast-episode-title">{{ $podcast->episode_name }}</h5>
                        
                        <p>
                            {{$podcast->episode_description}}
                        </p>

                    </div>     
                </div>
            </a>
            @endforeach

            <p class="center-align">
                <a href="/episodes" class=" waves-effect waves-light btn">VIEW OLDER EPISODES</a>
            </p>
        </div>
    @else
        <h4 class="center-align padcast-page-header" style="margin-bottom:50px;">Oops sorry we have no episodes yet</h4>
    @endif
</div>