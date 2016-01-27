<div class="row">

    <!-- Side Nav -->
    @include('app.includes.sections.sidenav')

    <!-- Feeds Area -->
    <div class="col s12 m8 l9">

        @if(Request::is('faqs*'))

            @include('app.includes.contents.faqs')

        @elseif (Request::is('about*'))

            @include('app.includes.contents.about')

        @elseif (Request::is('privacypolicy*'))

            @include('app.includes.contents.privacypolicy')

        @elseif (Request::is('search*'))

            @include('app.includes.contents.search')

        @else

        @endif


    </div>

</div>
