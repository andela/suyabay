<div class="row">

<!-- Side Nav -->

@include('app.includes.sections.sidenav')

    <!-- Feeds Area -->
    <div class="col s12 m8 l9">
        @forelse($episodes as $episode)
        <!-- start card -->
        <div class="card">

            <div class="col s12 m6 l4">
                <div class="card-image waves-effect waves-block waves-light">
                    <img src="{!! asset($episode->image) !!}">
                </div>
            </div>

            <div class="col s12 m8 l8">
                <div class="spacer">
                    <small>
                        {{ date('F d, Y', strtotime($episode->created_at)) }}
                        <span class="badge left teal lighten-2">
                            {{ $episode->channel->channel_name}}
                        </span>
                    </small>
                </div>

                <div>
                    <h4>
                        {{ $episode->episode_name }}
                    </h4>
                </div>

                <!-- Feed the audio source -->
                <div>
                    <audio src="{!! asset($episode->audio_mp3) !!}" preload="auto" />
                </div>

                <div>
                    <p>
                        {{ $episode->episode_description }}
                    </p>
                </div>
            </div>

            <div class="col s12 m6 l12 card-social">

            <!-- start social -->
                <div style="color:#999;" class="right">
                    <p>
                        <span style="padding-right:15px;">
                            <i class="fa fa-comment" id="comment-count{{ $episode->id }}"> {{ $episode->comment()->count() }}</i>
                        </span>
                        <span style="padding-right:15px;">
                            <i class="fa fa-heart"> 50</i>
                        </span>
                        <span style="padding-right:15px;">
                            <i class="fa fa-facebook"></i>
                        </span>
                        <span style="padding-right:15px;">
                            <i class="fa fa-twitter"></i>
                        </span>
                        <span style="padding-right:15px;">
                            <i class="fa fa-google-plus"></i>
                        </span>
                    </p>
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

                                <li class="load_comment{{ $episode->id }}">
                                @foreach ( $episode->comment as $comment  )
                                    <div id="show_comment" class="collection-item avatar show_comment{{ $comment->episode_id }}">
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
                                            <form id="submit_comment{{ $episode->id }}" action="/comment" method="POST">
                                                <div class="file-field input-field">
                                                    <input hidden="true" type="text" name="_token" id="_token{{ $episode->id }}" value="{{ csrf_token() }}">
                                                    <input hidden="true" type="text" name="user_id" id="user_id{{ $episode->id }}" value="{{ Auth::user()->id }}">
                                                    <input hidden="true" type="text" name="episode_id" id="episode_id{{ $episode->id }}" value="{{ $episode->id }}">
                                                    <div class="file-path-wrapper input-field col s10 m10">
                                                        <input name="comment" id="comment-field{{ $episode->id }}" class="validate" type="text" style="margin-left:20px;" required="true" />
                                                    </div>
                                                    <button type="submit" data-id="{{ $episode->id }}" data-token="{{ csrf_token() }}" data-comment-count="{{ $episode->comment()->count() }}" data-avatar="{{ Auth::user()->getAvatar() }}" id="submit"class="btn right comment-submit"><i class="fa fa-paper-plane-o"></i></button>
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

            </div>



        <!-- end card -->

        @empty
            <p>No Episodes to display</p>
        @endforelse

        <!-- Pagination -->
        <div class="row center-align fix">
            <div class="center-align">
                {!! $episodes->render() !!}
            </div>
        </div>
    </div>
</div>