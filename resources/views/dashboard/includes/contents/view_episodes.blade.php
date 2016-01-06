<!-- this is index -->
<div class="col s12 m9">
  @include('dashboard.includes.sections.alerts')
    <div class="row">
    @foreach($episodes as $episode)
        <div class="card col s5 m4 episode-item">
            <div class="card-image waves-effect waves-block waves-light">
                <img class="activator" src="{!! asset($episode->image) !!}">
            </div>

            <div class="">
                <span class="card-title activator grey-text text-darken-4">{{ $episode->episode_name }}</span><br>
                <span><i class="fa fa-heart">300k</i></span>
                <span><i class="fa fa-comment">300k</i></span>
                <span><i class="fa fa-play-circle">300k</i></span>
            </div>

            <div class="card-reveal">
                <span class="card-title grey-text text-darken-4">{{ $episode->episode_name }}<i class="material-icons right">close</i></span>

                <p>{{ $episode->episode_description }}</p>

                <a href="/dashboard/episode/{{ $episode->id }}/edit" class="waves-effect waves-light btn">
                    Edit
                </a>
                <a href="/dashboard/episode/{{ $episode->id }}/delete" class="waves-effect waves-light btn">
                    Delete
                </a>
            </div>

        </div>
        @endforeach
    </div>
</div>