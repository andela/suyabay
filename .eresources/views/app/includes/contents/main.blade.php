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

        <div class="card">

            <div class="col s12 m6 l4">
                <div class="card-image waves-effect waves-block waves-light">
                    <img src="https://goo.gl/1kUYlL">
                </div>

                <!-- Social icons start-->

                <div>
                    <span class="grey-text text-darken-4">
                        <a href="#!" title="share"><i class="tiny material-icons left">share</i></a>
                        <a href="#!" title="number of views"><i class="tiny material-icons left">live tv</i></a>
                        <a href="#!" title="comments"><i class="tiny material-icons left">forum</i></a>
                        <a href="#!" title="favorites"><i class="tiny material-icons left">favorite</i></a>
                        <a href="#!" title="downloads"><i class="tiny material-icons left">backup</i></a>
                    </span>
                </div>

                <!-- social icons end -->

                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">
                        Card Title
                            <i class="material-icons right grey-text text-darken-4">close</i>
                    </span>
                        <p>
                            Here is some more information about this product that is only revealed once clicked on.
                        </p>
                </div>
            </div>


            <div class="col s12 m8 l8">

                <div class="episode-date" id="episode-date">
                    <small>
                        21 september, 2015
                            <span class="new badge left teal lighten-2"></span>
                    </small>
                </div>

                <div id="episode-title">
                    <a href"#">
                        <h2>
                            <span id="channel-title">
                                Laravel Love Affairs
                            </span>
                        </h2>
                    </a>
                </div>

                    <!-- Feed the audio source with the three diff formats for browser compactibility-->
                    <audio preload="auto" controls>
                        <source src="audio/BlueDucks_FourFlossFiveSix.mp3">
                        <source src="audio/BlueDucks_FourFlossFiveSix.ogg">
                        <source src="audio/BlueDucks_FourFlossFiveSix.wav">
                    </audio>

                <div id="description">
                    <p>
                        In this episode, Matt and Taylor are joined by Ian Landsman of UserScape. Ian is the founder of UserScape, the creator of HelpSpot, and the man behind LaraJobs.
                    </p>
                </div>


            </div>
        </div>

        <div class="card">

            <div class="col s12 m6 l4">
                <div class="card-image waves-effect waves-block waves-light">
                    <img src="https://goo.gl/1kUYlL">
                </div>

                <!-- Social icons start-->

                <div>
                    <span class="grey-text text-darken-4">
                        <a href="#!" title="share"><i class="tiny material-icons left">share</i></a>
                        <a href="#!" title="number of views"><i class="tiny material-icons left">live tv</i></a>
                        <a href="#!" title="comments"><i class="tiny material-icons left">forum</i></a>
                        <a href="#!" title="favorites"><i class="tiny material-icons left">favorite</i></a>
                        <a href="#!" title="downloads"><i class="tiny material-icons left">backup</i></a>
                    </span>
                </div>

                <!-- social icons end -->

                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">
                        Card Title
                            <i class="material-icons right grey-text text-darken-4">close</i>
                    </span>
                        <p>
                            Here is some more information about this product that is only revealed once clicked on.
                        </p>
                </div>
            </div>


            <div class="col s12 m8 l8">

                <div class="episode-date" id="episode-date">
                    <small>
                        21 september, 2015
                            <span class="new badge left teal lighten-2"></span>
                    </small>
                </div>

                <div id="episode-title">
                    <a href"#">
                        <h2>
                            <span id="channel-title">
                                Laravel Love Affairs
                            </span>
                        </h2>
                    </a>
                </div>

                    <!-- Feed the audio source with the three diff formats for browser compactibility-->
                    <audio preload="auto" controls>
                        <source src="audio/BlueDucks_FourFlossFiveSix.mp3">
                        <source src="audio/BlueDucks_FourFlossFiveSix.ogg">
                        <source src="audio/BlueDucks_FourFlossFiveSix.wav">
                    </audio>

                <div id="description">
                    <p>
                        In this episode, Matt and Taylor are joined by Ian Landsman of UserScape. Ian is the founder of UserScape, the creator of HelpSpot, and the man behind LaraJobs.
                    </p>
                </div>


            </div>
        </div>



        <!-- view older episodes -->

        <div class="row center-align fix">
            <div class="center-align">
                <a href="episodes" class="btn-large">View Older episodes</a>
            </div>
        </div>
    </div>
</div>
