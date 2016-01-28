<!-- this is index -->
<div class="col s12 m9">
    <div class="row">
    @forelse($episodes as $episode)
        <div class="card col s5 m4 episode-item">
            <div class="card-image waves-effect waves-block waves-light">
                <img class="activator" src="{!! asset($episode->image) !!}">
            </div>
            <div class="card-reveal">
                <span class="card-title grey-text text-darken-4">{{ $episode->episode_name }}<i class="material-icons right">close</i></span>

                <p>{{ $episode->episode_description }}</p>

                <a href="/dashboard/episode/{{ $episode->id }}/edit" class="waves-effect waves-light btn">
                    <i class="fa fa-pencil"></i>Edit
                </a>
                <a href="/dashboard/episode/{{ $episode->id }}/delete" class="waves-effect waves-light btn" data-id="" data-name="">
                    <i class="fa fa-trash-o"></i>Delete
                </a>
            </div>
        </div>
        @empty
        no content
        @endforelse
    </div>
</div>