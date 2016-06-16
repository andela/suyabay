<div class="row">

<!-- Side Nav -->

    @include('app.includes.sections.sidenav')

    <!-- Feeds Area -->
    @if($episodes->count() > 0)
    <div class="col s12 m8 l9">

        <h4 class="center-align padcast-page-header" style="margin-bottom:50px;">Podcast for Suya lovers</h4>

        @foreach($episodes->take(-4) as $podcast)
            @include('app.includes.contents.podcast')
        @endforeach

        <p class="center-align">
            <a href="/episodes" class=" waves-effect waves-light btn">VIEW OLDER EPISODES</a>
        </p>
        @else
            <h4 class="center-align padcast-page-header" style="margin-bottom:50px;">Oops sorry we have no episodes yet</h4>
        @endif
    </div>
</div>