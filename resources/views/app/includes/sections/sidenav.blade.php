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
