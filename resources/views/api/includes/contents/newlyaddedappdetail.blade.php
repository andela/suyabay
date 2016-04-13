@if ( Auth::check() )

        <!-- top nav -->
    @include("api.includes.sections.top_nav")

    <div class="row">
        <div class="col s8">
            <div id="main-one-app">
                <p class="app-name">{{ $appDetail->name }}</p>
                <a class="wavesapp waves btn" href="#">Edit app</a>
            
                    <span class="col s12">Owner</span>
                    <p class="col s12"> {{ auth()->User()->username }} </p>
                
                    <span class="col s12">Homepage url</span>
                    <p class="col s12">{{ $appDetail->homepage_url }}</p>    

                    <span class="col s12">App Token</span>
                    <p class="col s12" style="white-space: pre-wrap; word-wrap: break-word;">{{ $appDetail->api_token }}</p>    
            </div>    
        </div>

        <div class="col s4">
            <div id="main-two-app">
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