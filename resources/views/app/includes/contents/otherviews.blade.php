<div class="row">

    <!-- Side Nav -->
    @include('app.includes.sections.sidenav')

    <!-- Feeds Area -->
    <div class="col s12 m8 l9">
        <h4>Results</h4>
    @if (! $results->count())
      <p>No results found, sorry</p>
    @else
        @foreach($results as $podcast)
        <a style="color:#2C3E50" href="/episode/{{$podcast->id}}">
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
    @endif
    <a class = "btn btn-primary" href="/">Back</a>
    </div>

</div>
