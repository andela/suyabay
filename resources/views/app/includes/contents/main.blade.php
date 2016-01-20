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
                <div style="color:#999;">
                    <p>
                        <span style="padding-right:15px;">
                            <i class="fa fa-compass"> 30</i>
                        </span>
                        <span style="padding-right:15px;">
                            <i class="fa fa-heart"> {{ $episode->likes }}</i>
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
                                @if (  Auth::check() )
                                    <li class="collection-item avatar">
                                        <div class="row">
                                            <div class="col s2">
                                                <img src="https://goo.gl/IJSkVB" alt="" class="circle">
                                            </div>
                                            <form action="/comment" method="POST">
                                                <div class="file-field input-field">
                                                    <input hidden="true" type="text" name="_token" value="{{ csrf_token() }}">
                                                    <input hidden="true" type="text" name="user_id" value="{{ Auth::user()->id }}">
                                                    <input hidden="true" type="text" name="episode_id" value="{{ $episode->id }}">
                                                    <div class="file-path-wrapper col s9 m10">
                                                        <input name="comment" id="comment-field" class="file-path validate" type="text" style="margin-left:20px;">
                                                    </div>
                                                    <button class="btn">Comment</button>
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

                                @foreach ( $episode->comment as $comment  )
                                    <li class="collection-item avatar">
                                        <div class="row">

                                            <div class="col s2">
                                                <img src="https://goo.gl/lVRGjF" alt="" class="circle">
                                            </div>
                                            <div class="col s10">
                                                <div class="textarea-wrapper" placeholder="">
                                                    {{$comment->comments}}
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
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
