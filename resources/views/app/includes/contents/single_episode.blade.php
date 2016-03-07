<div class="row">

<!-- Side Nav -->

 @include('app.includes.sections.sidenav')

    <!-- Feeds Area -->
    <div class="col s12 m8 l9">
           
        <h4 class="center-align padcast-page-header" style="margin-bottom:50px;">Podcast for Suya lovers</h4>

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
                    {{ $episodes->first()->episode_description }}
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

            <div class="col s12 m6 l12 card-social">
                <div>
                    <ul class="collapsible" data-collapsible="accordion">
                        <li>
                            <div class="collapsible-body episode_comments">

                                <ul class="collection">

                                <li class="load_comment" data-token="{{ csrf_token() }}">
                                    @foreach ( $firstTenEpisodes as $comment )
                                        <div id="show_comment" class="collection-item avatar show_comment">
                                            <div class="row">
                                                <div class="col s2">
                                                    <img src="{{ $comment->user->getAvatar() }}" alt="" class="circle">
                                                </div>
                                                <div class="col s10">
                                                    <div class="textarea-wrapper" data-comment-id="{{ $comment->id }}" data-token="{{ csrf_token() }}">
                                                        <span>
                                                            {{$comment->comments}}
                                                        </span>

                                                        @if( Auth::check() )

                                                            @if ( Auth::user()->id === $comment->user_id )
                                                            <div class="update-actions pull-right">
                                                                <a href="#" id="comment_action_caret" class="fa fa-bars no-style-link"></a> 
                                                                <div id="comment_actions" style="display:none">
                                                                    <a href="#" class="fa fa-pencil comment-action-edit no-style-link" data-commentId="{{ $comment->comment_id }}"></a>
                                                                    <a href="#" class="fa fa-trash comment-action-delete no-style-link" data-commentId="{{ $comment->id }}"></a>
                                                                </div>
                                                            </div>

                                                             @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </li>
                                    @if ( Auth::check())
                                        <input type="hidden" id="episode_id" value=" {{ $firstTenEpisodes[0]['episode_id'] }}" />
                                        <input type="hidden" id="episode_id" value="{{ $lu = $episodes->first()->comment()->orderBy('created_at', 'asc')->take(10)->get()}} {{ $lu[0]['episode_id'] }}" />

                                        <input type="hidden" id="episode_id" value="{{ $lu = $episodes->first()->comment()->orderBy('created_at', 'asc')->take(10)->get()}} {{ $lu[0]['episode_id'] }}" />
                                            @if(count($firstTenEpisodes) > 0)
                                                <li>
                                                    <div class="view_more_comments" data-avatar="{{ Auth::user()->getAvatar() }}">
                                                        <a href="#" title="View more comments">
                                                            View more comments
                                                        </a>
                                                    </div>
                                                </li>
                                            @endif

                                    <li class="collection-item avatar">
                                        <div class="row">
                                            <div class="col s2">
                                                <img src="{{ Auth::user()->getAvatar() }}" alt="" class="circle">
                                            </div>

                                            <form id="submit_comment" method="POST">
                                                <div class="file-field input-field">
                                                    <input hidden="true" type="text" name="_token" id="_token" value="{{ csrf_token() }}">
                                                    <input hidden="true" type="text" name="episode_id" id="episode_id" value="{{ $episodes->first()->id }}">
                                                    <div class="file-path-wrapper input-field col s10 m10">
                                                        <input name="comment" id="new-comment-field" class="validate" type="text" style="margin-left:20px;" required="true" />
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
