<div class="row">

    <!-- Side Nav -->
    <div class="col s3">
        <div class="hide-on-small-only">
            <div class="collection">
                <a href="#" class="collection-item">Channels <span class="new badge">4</span></a>
                <a href="#" class="collection-item">Favourites <span class="new badge">0</span></a>
                <a href="#" class="collection-item" id="view-all-episodes">See all episodes <span class="badge">10+</span></a>
                <a href="{{ URL::to('about') }}" class="collection-item">About</a>
                <a href="{{ URL::to('privacypolicy') }}" class="collection-item">Privacy Policy</a>
                <a href="{{ URL::to('faqs') }}" class="collection-item">FAQs</a>
            </div>
        </div>
    </div>

    <!-- Feeds Area -->
    <div class="col s12 m8 l9" style="opacity: 0.95;">

        @foreach($episodes as $episode)

        <div class="card">

            <div class="col s12 m6 l4">

                <div class="card-image waves-effect waves-block waves-light">
                    <img src="http://lorempixel.com/640/480/">
                </div>

            </div>

            <div class="col s12 m8 l8">

                <div class="episode-date" id="episode-date">
                    <small>
                        {{ date('F d, Y', strtotime($episode->created_at)) }}

                    </small>
                </div>

                <div id="episode-title truncate">
                    <a href"#">
                        <h2>
                            {{ $episode->episode_name }}
                        </h2>
                    </a>
                </div>
            <div>

            <!-- Feed the audio source with the three diff formats for browser compactibility-->
                <audio preload="auto" controls>
                    <source src="audio/BlueDucks_FourFlossFiveSix.mp3">
                    <source src="audio/BlueDucks_FourFlossFiveSix.ogg">
                    <source src="audio/BlueDucks_FourFlossFiveSix.wav">
                </audio>
            </div>

            <div id="description">
                <p>
                    {{ $episode->episode_description }}
                </p>
            </div>

                <!-- Social icons start-->
            <div class="col s12 grey-text text-darken-4 center-align" style="margin:15px;">

                <a href="#!" title="share">
                    <i class="material-icons left">share</i>
                </a>
                <a href="#!" title="number of views">
                    <i class="material-icons left">live tv</i>
                </a>
                <a href="#!" title="comments">
                    <i class="material-icons left">forum</i>
                </a>
                <a href="#!" title="favorites">
                    <i class="material-icons left">favorite</i>
                </a>

            </div>

                <!-- social icons end -->

        </div>
    </div>

    @endforeach

        <!-- Pagination -->

    <div class="row center-align fix">
        <div class="center-align">
            {!! $episodes->render() !!}
        </div>
    </div>

    </div>
