<div class="row">
    <!-- Side Nav -->
    @include('app.includes.sections.sidenav')
    <!-- Feeds Area -->
    <div class="col s12 m8 l9">
        <h4 class="center-align padcast-page-header" style="margin-bottom:50px;">Podcast for Suya lovers</h1>
        @if ($episodes->count() > 0)
            @foreach($episodes as $podcast)
                @include('app.includes.contents.podcast')
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