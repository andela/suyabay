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
                <img class="responsive-img podcast-img" src="/images/image.png">
            </div>

            <div class="col s9 details">
                <span class="podcast-episode-date">7 July 2016</span>
                <span class="tag podcast-episode-date">7 July 2016</span>
                <h5 class="podcast-episode-title">Why yoruba girls will date you for suya</h5>
                
                <div>
                    <audio width="10px;" src="http://goo.gl/LkNP5M" preload="auto" />
                </div>
                <p>
                    In this episode, the crew discusses Linode down time, 
                    server migrations, editors, Will Smith, and Mario Kart. Most importantly, 
                    Jeffrey & Taylor finally disagree.
                </p>

                <div class="podcast-actions">                    
                    <span style="padding-right:15px;">
                        <i class="social-btn fa fa-heart"></i>
                    </span>
                    <span style="padding-right:15px;">
                        <i class="social-btn fa fa-twitter"></i>
                    </span>                    
                    <span style="padding-right:15px;">
                        <i class="social-btn fa fa-facebook"></i>
                    </span>            

                </div>
            </div>
                   
        </div>

        <div class="row podcast">
            <div class="col s3">
                <img class="responsive-img podcast-img" src="/images/image.png">
            </div>

            <div class="col s9 details">
                <span class="podcast-episode-date">7 July 2016</span>
                <span class="tag podcast-episode-date">7 July 2016</span>
                <h5 class="podcast-episode-title">Why yoruba girls will date you for suya</h5>
                
                <p>
                    In this episode, the crew discusses Linode down time, 
                    server migrations, editors, Will Smith, and Mario Kart. Most importantly, 
                    Jeffrey & Taylor finally disagree.
                </p>

            </div>
                   
        </div>
    </div>
</div>
