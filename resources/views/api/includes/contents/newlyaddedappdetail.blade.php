@if ( Auth::check() )

        <!-- top nav -->
    @include("api.includes.sections.top_nav")

    <div class="row">
        <div class="col s8">
            <div id="main-one">
                <h5 class="app-name">{{ $appDetails->name }}</h5>
                <a class="waves-effect waves btn" href="#">Edit this app</a>
                <div class="app-detail">
                    <p class="owner">Owner</p>
                    <p class="owner-ifo"> {{ auth()->User()->username }} </p>
                    <p class="owner">Homepage url</p>
                    <p class="owner-info">{{ $appDetails->homepage_url }}</p>
                    <p class="owner">App Token</p>
                    <p class="owner-info">{{ $appDetails->api_token }}</p>
                </div>    
            </div>    
        </div>

        <div class="col s4">
            <div id="main-two">
                <div class="session-one">
                    <a class="waves-effect waves-one btn" href="/developer/myapp/new">Create a new app</a>
                </div> 
                <div class="session-two">

                </div>
                 <div class="session-three">

                </div>
            </div>  
        </div>
    </div>

@else 

	<!-- top nav -->
        @include("api.includes.sections.top_nav")

    <!--auth check error page -->    
        @include("api.includes.contents.autherrorpage")

@endif    