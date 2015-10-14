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

            <p>error</p>

        @endif


    </div>

</div>
