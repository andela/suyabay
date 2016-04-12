@if ( Auth::check() )

        <!-- top nav -->
    @include("api.includes.sections.top_nav")

    <div class="row">
        <div class="col s8">
            <div id="main-one">
                <span class="app-name">{{ $appDetail->name }}</span>
                <a class="wavesapp waves btn" href="#">Edit app</a>

                <div class="app-detail">
                    <span class="owner">Owner</span>
                    <p class="owner-info"> {{ auth()->User()->username }} </p>
                    <span class="owner">Homepage url</span>
                    <p class="owner-info">{{ $appDetail->homepage_url }}</p>
                    <span class="owner">App Token</span>
                    <p class="owner-token">{{ $appDetail->api_token }}</p>
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