<div class="row">
    <!-- Side Nav -->
    @include('app.includes.sections.sidenav')
    <!-- Feeds Area -->
    <div class="col s12 m8 l9">
        <h4 class="center-align padcast-page-header" style="margin-bottom:50px;">Podcast for Suya lovers</h1>
        @if ($episodes->count() > 0)
            @foreach($episodes as $podcast)
                <a style="color:#2C3E50" href="/episodes/{{$podcast->id}}">
                    <div class="row podcast">
                        <div class="col s3">
                            <img class="responsive-img podcast-img" src="{{ asset($podcast->image) }}">
                        </div>

                        <div class="col s9 details">
                            <span class="podcast-episode-date">{{ $podcast->created_at->diffForHumans() }}</span>
                            <h5 class="podcast-episode-title"> <i class="fa fa-eye" aria-hiddden="true"></i> {{ $podcast->views }}</h5>
                            <h5 class="podcast-episode-title">{{ $podcast->episode_name }}</h5>

                            <p>
                                {{$podcast->episode_description}}
                            </p>

                            <span class="podcast-episode-date align-left">{{$podcast->channel->channel_name}}</span>

                        </div>
                    </div>
                </a>
            @endforeach
        @else
        <div class="col s12">
            <div class="card-panel grey lighten-5 z-depth-1">
                <div class="row valign-wrapper">
                    <div class="col s12">
                        <h4 class="black-text center">
                        <i class="fa fa-info-circle teal-text"></i> Ooops, there are no episodes in this channel
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <p class="center-align">
            <a href="/" class=" waves-effect waves-light btn">Back home</a>
        </p>
    </div>
</div>