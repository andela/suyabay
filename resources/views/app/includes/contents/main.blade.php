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
                <a href="{{ URL::to('about') }}" class="collection-item">About</a>
                <a href="{{ URL::to('privacypolicy') }}" class="collection-item">Privacy Policy</a>
                <a href="{{ URL::to('faqs') }}" class="collection-item">FAQs</a>
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
                            <i class="fa fa-compass"> 200</i>
                        </span>
                        <span style="padding-right:15px;">
                            <i class="fa fa-heart"> 200</i>
                        </span>
                        <span style="padding-right:15px;">
                            <i class="fa fa-share-alt"> 200</i>
                        </span>
                    </p>
                </div>
            </div>
            <div class="col s12 m6 l12 card-social">
                <div>
                    <ul class="collapsible" data-collapsible="accordion">
                        <li>
                            <div class="collapsible-header" style="color:#999;padding-left:15px;">
                                comments
                            </div>
                            <div class="collapsible-body">
                                <ul class="collection">
                                    <li class="collection-item avatar">
                                        <span>
                                            <img src="http://res.cloudinary.com/suyabay/image/facebook/serenawilliams.jpg" alt="" class="circle">
                                        </span>
                                        <span class="bubble-content" style="color:#999;margin-left:40px;">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean ipsum tellus, hendrerit tristique ligula vitae, semper eleifend ipsum.
                                                <div class="point"></div>
                                        </span>
                                    </li>
                                    <li class="collection-item avatar">
                                        <span>
                                            <img src="http://res.cloudinary.com/suyabay/image/facebook/billclinton.jpg" alt="" class="circle">
                                        </span>
                                        <span class="bubble-content" style="color:#999;margin-left:40px;">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean ipsum tellus, hendrerit tristique ligula vitae, semper eleifend ipsum.
                                                <div class="point"></div>
                                        </span>
                                    </li>
                            </div>
                        </li>
                    </ul>
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
