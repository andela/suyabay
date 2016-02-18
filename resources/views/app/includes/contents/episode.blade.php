<div class="row">

<!-- Side Nav -->

    <div class="col s3">
        <div class="hide-on-small-only">
            <div class="collection">
                <a href="/channels" class="collection-item">Channels <span class="new badge">4</span></a>
                <a href="/episodes" class="collection-item" id="view-all-episodes">See all episodes--
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
           
        <h4 class="center-align padcast-page-header" style="margin-bottom:50px;">Podcast for Suya lovers</h1>

        @foreach($episodes as $podcast)
        <a style="color:#2C3E50" href="/episodes/{{$podcast->id}}">
            <div class="row podcast">
                <div class="col s3">
                    <img class="responsive-img podcast-img" src="{{ asset($podcast->image) }}">
                </div>

                <div class="col s9 details">
                    <span class="podcast-episode-date">{{ $podcast->created_at->diffForHumans() }}</span>
                    <span class="tag podcast-episode-date">{{$podcast->channel->channel_name}}</span>
                    <h5 class="podcast-episode-title">{{ $podcast->episode_name }}</h5>
                    
                    <p>
                        {{$podcast->episode_description}}
                    </p>

                </div>     
            </div>
        </a>
        @endforeach

        <p class="center-align">
            <a href="/" class=" waves-effect waves-light btn">Back home</a>
        </p>
    </div>
</div>
