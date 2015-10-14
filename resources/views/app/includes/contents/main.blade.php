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
                <div class="card-image waves-effect waves-block waves-light episode-avatar">
                    <img src="http://cdn.c.photoshelter.com/img-get/I0000FeyfQ4zNA1U/t/200/I0000FeyfQ4zNA1U.jpg">
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
                    <h5> Episode
                        <span id="episode-id">
                            01:
                        </span>

                        <span id="channel-title">
                            Laravel Love Affairs Part 1
                        </span>
                    </h5>
                </div>

                    <!-- Feed the audio source with the three diff formats for browser compactibility-->
                    <audio preload="auto" controls>
                        <source src="audio/BlueDucks_FourFlossFiveSix.mp3">
                        <source src="audio/BlueDucks_FourFlossFiveSix.ogg">
                        <source src="audio/BlueDucks_FourFlossFiveSix.wav">
                    </audio>

                <div id="description">
                    <p>
                        In this episode, Matt and Taylor are joined by Ian Landsman of UserScape. Ian is the founder of UserScape, the creator of HelpSpot, and the man behind LaraJobs. The crew discusses hiring, being a good job candidate, and most importantly: Star Wars.
                    </p>
                </div>

                <div class="action-btn">
                    <span class="grey-text text-darken-4">

                    <i class="fa fa-share-alt left"></i>
                    <i class="small material-icons right">visibility</i>
                    <i class="small material-icons right">forum</i>
                    <i class="small material-icons right">loyalty</i>
                    <br><br>
                    </span>

                </div>

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
        </div>

         <div class="card">

            <div class="col s12 m6 l4">
                <div class="card-image waves-effect waves-block waves-light episode-avatar">
                    <img src="http://cdn.c.photoshelter.com/img-get/I0000FeyfQ4zNA1U/t/200/I0000FeyfQ4zNA1U.jpg">
                </div>
            </div>


            <div class="col s12 m8 l8">

                <div class="episode-date" id="episode-date">
                    <small>
                        20 september, 2015
                            <span class="new badge left teal lighten-2"></span>
                    </small>
                </div>

                <div id="episode-title">
                    <h5> Episode
                        <span id="episode-id">
                            02:
                        </span>

                        <span id="channel-title">
                            Cute Tools
                        </span>
                    </h5>
                </div>

                <!-- Feed the audio source with the three diff formats for browser compactibility-->
                    <audio preload="auto" controls>
                        <source src="audio/BlueDucks_FourFlossFiveSix.mp3">
                        <source src="audio/BlueDucks_FourFlossFiveSix.ogg">
                        <source src="audio/BlueDucks_FourFlossFiveSix.wav">
                    </audio>

                <div id="description">
                    <p>
                        Testing, 100% minimum coverage, TDD. The consequences of long-term high-intensity focus. What does PHPSpec have to offer? The battle over Trait / Interface suffixes. Imposter Syndrome. Links to other Podcasts mentioned in this episode. http://www.thisamericanlife.org/
                    </p>
                </div>

                <div>
                    <span class="grey-text text-darken-4">

                    <i class="fa fa-share-alt left"></i>
                    <i class="small material-icons right">visibility</i>
                    <i class="small material-icons right">forum</i>
                    <i class="small material-icons right">loyalty</i>
                     <br><br>
                    </span>

                </div>

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
        </div>

        <!-- view older episodes -->

        <div class="row center-align fix">
            <div class="podcast-page-navigation center-align">
                <a href="{{ URL::to('episodes') }}" class="blue-grey-text darken-4">
                    view older episodes
                </a>
            </div>
        </div>
    </div>
</div>
