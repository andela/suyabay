@section('mobile-nav')
<ul id="nav-mobile" class="side-nav collection">

    <li class="collection-item">
        <a href="#">CHANNELS <span class="new badge grey darken-2" style="padding:5px;">{{ $channels->count() }}</span></a>
    </li>

    <li class="collection-item">
        <a href="#">FAVOURITES <span class="badge grey darken-2" style="padding:5px;">3</span></a>
    </li>

    <li class="collection-item center-align">
        <a href="{{ URL::to('search') }}">SEARCH</a>
    </li>

    <li class="collection-item">
        <a href="{{ URL::to('login') }}">SIGN IN</a>
    </li>

    <li class="collection-item">
        <a href="{{ URL::to('signup') }}">SIGN UP</a>
    </li>

    <li class="collection-item">
        <a href="{{ URL::to('about') }}">ABOUT</a>
    </li>

    <li class="collection-item">
        <a href="{{ URL::to('faqs') }}">FAQs</a>
    </li>

    <li class="collection-item">
        <a href="{{ URL::to('privacypolicy') }}">PRIVACY POLICY</a>
    </li>

</ul>
@endsection
    <div class="col s3">
        <div class="hide-on-small-only">
            <div class="collection">
                <a href="/channels" class="collection-item">Channels <span class="new badge">{{ $channels->count() }}</span></a>
                @if(!Auth::check())
                <a href="{{ URL::to('about') }}" class="collection-item">About</a>
                <a href="{{ URL::to('privacypolicy') }}" class="collection-item">Privacy Policy</a>
                <a href="{{ URL::to('faqs') }}" class="collection-item">FAQs</a>
                @else
                <a href="/favorites" class="collection-item">Favourites <span class="badge" id="favorite">{{ $favorites->count() }}</span></a>
                @endif
            </div>
        </div>
    </div>