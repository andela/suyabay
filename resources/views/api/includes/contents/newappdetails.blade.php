        <!-- top nav -->
    @include("api.includes.sections.top_nav")

    <div class="row">
        <div class="col s8">
            <div id="main-one-app">
                <div class='row'>
                    <p class="app-name">{{ $appDetail->name }}</p>
                    <a class="wavesapp waves btn" href="#">Edit app</a>
                </div>

                <div class='app-details'>
                    <div class=>
                        <p style="font-weight: 600;">Owner</p>
                        <p> {{ auth()->User()->username }} </p>
                    </div>
                    <hr>
                    <div class=>
                        <p style="font-weight: 600;">Homepage url</p>
                        <p>{{ $appDetail->homepage_url }}</p>    
                    </div>
                    <hr>
                    <div class=>
                        <p style="font-weight: 600;">App Token</p>
                        <p style="white-space: pre-wrap; word-wrap: break-word;">{{ $appDetail->api_token }}</p> 
                    </div> 
                </div>    
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