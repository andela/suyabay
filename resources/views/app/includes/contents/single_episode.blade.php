<div class="row">

<!-- Side Nav -->
    <div class="col s3">
        <div class="hide-on-small-only">
            <div class="collection">
                <a href="#" class="collection-item">Channels <span class="new badge">4</span></a>
                <a href="#" class="collection-item">Favourites <span class="new badge">0</span></a>
                <a href="#" class="collection-item" id="view-all-episodes">See all episodes
                    <span class="badge">10+</span>
                </a>
                @can('guest', Auth::check())
                <a href="{{ URL::to('about') }}" class="collection-item">About</a>
                <a href="{{ URL::to('privacypolicy') }}" class="collection-item">Privacy Policy</a>
                <a href="{{ URL::to('faqs') }}" class="collection-item">FAQs</a>
                @endcan
            </div>
        </div>
    </div>

    <!-- Feeds Area -->
    <div class="col s12 m8 l9">
           
        <h4 class="center-align padcast-page-header">Podcast for Suya loves</h1>
        

        <p class="flow-text center-align padcast-page-sub-header">
            The Laravel Podcast brings you Laravel and PHP development news and discussion. The podcast is hosted by Matt Stauffer and regular guests include Taylor Otwell (the creator of Laravel) and Jeffrey Way (the creator of Laracasts).
        </p>

        <div class="row podcast">
            <div class="col s3">
                <img class="responsive-img podcast-img" src="{{ asset($episodes->first()->image) }}">
            </div>

            <div class="col s9 details">
                <span class="podcast-episode-date">{{ $episodes->first()->created_at->diffForHumans() }}</span>
                <span class="tag podcast-episode-date">{{ $episodes->first()->channel->channel_name }}</span>
                <h5 class="podcast-episode-title">{{ $episodes->first()->episode_name }}</h5>
                
                <div>
                    <audio width="10px;" src="{{ $episodes->first()->audio_mp3 }}" preload="auto" />
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
                        <i class="social-btn fa fa-twitter"></i>
                    </span>                    
                    <span style="padding-right:15px;">
                        <i class="social-btn fa fa-facebook"></i>
                    </span>            
                </div>
         
            </div>


            <div class="col s12 m6 l12 card-social">
                <div>
                    <ul class="collapsible" data-collapsible="accordion">
                        <li>
                            <div class="collapsible-header" style="color:#999;padding-left:15px;">
                                <b>Comments</b>
                            </div>
                            <div class="collapsible-body">
                                <ul class="collection">

                                <li class="load_comment">
                                    @foreach ( $episodes->first()->comment as $comment  )
                                        <div id="show_comment" class="collection-item avatar show_comment">
                                            <div class="row">

                                                <div class="col s2">
                                                    <img src="{{ $comment->user->getAvatar() }}" alt="" class="circle">
                                                </div>
                                                <div class="col s10">
                                                    <div class="textarea-wrapper" placeholder="">
                                                        {{$comment->comments}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </li>

                                @if (  Auth::check() )
                                    <li class="collection-item avatar">
                                        <div class="row">
                                            <div class="col s2">
                                                <img src="{{ Auth::user()->getAvatar() }}" alt="" class="circle">
                                            </div>
                                            <form id="submit_comment" method="POST">
                                                <div class="file-field input-field">
                                                    <input hidden="true" type="text" name="_token" id="_token" value="{{ csrf_token() }}">
                                                    <input hidden="true" type="text" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
                                                    <input hidden="true" type="text" name="episode_id" id="episode_id" value="{{ $episodes->first()->id }}">
                                                    <div class="file-path-wrapper input-field col s10 m10">
                                                        <input name="comment" id="comment-field" class="validate" type="text" style="margin-left:20px;" required="true" />
                                                    </div>
                                                    <button type="submit" data-token="{{ csrf_token() }}" data-comment-count="{{ $episodes->first()->comment()->count() }}" data-avatar="{{ Auth::user()->getAvatar() }}" id="submit" class="btn right comment-submit"><i class="fa fa-paper-plane-o"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </li>
                                @else
                                    <li class="collection-item avatar">
                                        <span>
                                        <i class="fa fa-user fa-2x circle"></i>
                                        </span>
                                        <span style="color:#999;margin-left:40px;">
                                            Only logged in users can comment.
                                            <div class="point"></div>
                                        </span>
                                    </li>
                                @endif

                            </div>
                        </li>
                    </ul>
                </div>
            </div>





        </div>

        <p class="center-align">
            <a href="/" class=" waves-effect waves-light btn">Back home</a>
        </p>
    </div>
</div>
