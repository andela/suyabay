@section('mobile-nav')
<ul id="nav-mobile" class="side-nav collection">

    <li class="collection-item">
        <a href="/channels">CHANNELS <span class="new badge grey darken-2" style="padding:5px;">{{ $channels->count() }}</span></a>
    </li>

    <li class="search">
        @include('app.includes.contents.searchform')
    </li>

    <li class="collection-item">
        <a href="{{ URL::to('login') }}">SIGN IN</a>
    </li>

    <li class="collection-item">
        <a href="{{ URL::to('new/signup') }}">SIGN UP</a>
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
            <a href="/channels" class="collection-item">View All Channels</a>
            @if (Auth::check())
            <a href="{{ route('favorites') }}" class="collection-item">Favourites<span class="badge" id="sidebar-fav">{{ Auth::user()->likesCount() }}</span></a>
            @endif
            <a href="/episodes" class="collection-item" id="view-all-episodes">See all episodes
                <span class="badge"></span>
            </a>
            @can('guest', Auth::check())
            <a href="{{ URL::to('about') }}" class="collection-item">About</a>
            <a href="{{ URL::to('privacypolicy') }}" class="collection-item">Privacy Policy</a>
            <a href="{{ URL::to('faqs') }}" class="collection-item">FAQs</a>
            @endcan
        </div>
    </div>
</div>
