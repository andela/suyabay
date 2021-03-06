<div class="row">

<!-- Side Nav -->

 @include('app.includes.sections.sidenav')

    <!-- Feeds Area -->
    <div class="col s12 m8 l9">

        <h4 class="center-align padcast-page-header" style="margin-bottom:50px;">Podcast for Suya lovers</h4>

        <div class="row podcast">
            <div class="col s3">
                <img class="responsive-img podcast-img" src="{{ asset($episode->image) }}">
            </div>

            <div class="col s9 details">

                <span class="podcast-episode-date">{{ $episode->created_at->diffForHumans() }}</span>
                <span class="tag podcast-episode-date"> <i class="fa fa-headphones fa-lg" aria-hiddden="true"></i> {{ $episode->views }} </span>
                <h5 class="podcast-episode-title">{{ $episode->episode_name }}</h5>
                <div>
                    <audio width="10px;" src="{{ $episode->audio_mp3 }}" preload="auto" />
                </div>

                <p>
                    {{ $episode->episode_description }}
                </p>

                <span class="podcast-episode-date align-left">{{ $episode->channel->channel_name }}</span>

                <div class="podcast-actions right">

                    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">

                    @if( Auth::check() )
                        <input type="hidden" id="user_id" value="{{ Auth::user()->id }}" >
                    @endif

                    <input type="hidden" id="episode_id" value="{{ $episode->id }}">

                    <span style="padding-right:15px;">
                         <i class="fa fa-heart social-btn like-btn like {{ $episode->like_status }}" like-status="{{ $episode->like_status }}" data-episode-id="{{ $episode->id }}"> </i> <span class="counts">{{ $episode->likes }}</span>
                    </span>

                    <span style="padding-right:15px;">
                        <i class="fa fa-comment social-btn like"> <span id="comment-count"></span></i> <span class="counts">{{ $episode->comment->count() }}</span>
                    </span>

                    <span style="padding-right:15px;">
                        <a href="#" class="twtr-share" data-desc="{{ $episode->episode_description }}" data-name="{{ $episode->episode_name }}" data-img="{!! asset($episode->image) !!}" data-url="{!! url('/episodes', $episode->id)  !!}">
                            <i class="fa fa-twitter social-btn "></i>
                        </a>
                    </span>
                    <span style="padding-right:15px;">
                        <a href="#" class="fb-share" data-desc="{{ $episode->episode_description }}" data-name="{{ $episode->episode_name }}" data-img="{!! asset($episode->image) !!}" data-url="{!! url('/episodes', $episode->id) !!}">
                            <i class="fa fa-facebook social-btn "></i>
                        </a>
                    </span>

                    <i id="auth-check" hidden data-auth="{{ Auth::user() ? 'true' : 'false' }}"></i>
                </div>

            </div>

            <div class="col s12 m6 l12 card-social">
                <div>
                    <ul class="collapsible" data-collapsible="accordion">
                        <li>
                            <div class="collapsible-body episode_comments">
                                <ul class="collection">

                                <li class="load_comment" data-token="{{ csrf_token() }}">

                                @if ( count($firstTenComments) <= 0 )
                                    <h6 style="padding: 10px; font-weight:400;">No comments to display for this episode</h6>
                                @else
                                    @foreach ( $firstTenComments as $comment )
                                      <div id="show_comment" class="collection-item avatar show_comment">
                                            <div class="row">
                                                <div class="col s2">
                                                    <img src="{{ $comment->user->getAvatar() }}" alt="" class="circle" onerror="this.src='http://www.gravatar.com/avatar/\'.md5(strtolower(trim($comment->user->email))).\'?d=mm&s=500'">
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
                                    @endif
                                </li>
                                    
                                    @if( $episode->comment->count() > 10)
                                        <li>
                                            <div class="view_more_comments">
                                                <a href="#" title="View more comments">
                                                    View more comments
                                                </a>
                                            </div>
                                        </li>
                                    @endif

                                    @if ( Auth::check() )

                                        @if( count($firstTenComments) > 0 )
                                            <input type="hidden" id="episode_id" value=" {{ $firstTenComments[0]['episode_id'] }}" />
                                        @endif
                                            
                                    <li class="collection-item avatar">
                                    
                                        <div class="row">
                                    
                                            <div class="col s2">
                                                <img src="{{ Auth::user()->getAvatar() }}" alt="" class="circle" onerror="this.src='http://www.gravatar.com/avatar/\'.md5(strtolower(trim($comment->user->email))).\'?d=mm&s=500'">
                                            </div>

                                            <form id="submit_comment" method="POST">
                                                <div class="file-field input-field">
                                                    <input hidden="true" type="text" name="_token" id="_token" value="{{ csrf_token() }}">
                                                    <input hidden="true" type="text" name="episode_id" id="episode_id" value="{{ $episode->id }}">
                                                    <div class="file-path-wrapper input-field col s10 m10">
                                                        <input name="comment" id="new-comment-field" class="validate" type="text" style="margin-left:20px;" required="true" />
                                                    </div>
                                                    <button type="submit" data-token="{{ csrf_token() }}" data-comment-count="{{ $episode->comment()->count() }}" data-avatar="{{ Auth::user()->getAvatar() }}" id="submit" class="btn right comment-submit"><i class="fa fa-paper-plane-o"></i></button>
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
