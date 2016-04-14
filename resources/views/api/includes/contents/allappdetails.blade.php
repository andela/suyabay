<!-- top nav -->
    @include("api.includes.sections.top_nav")

    <div class="row">
        <div class="col s8">
            <div id="main-one-apps">
                <h5 class="app-title" style="font-size: 30px;">My Apps</h5>
                <div class="myapps">
                    @foreach($allAppDetails as $allAppDetail)
                        <div class='all-app-details'>
                            <div class="app-name">
                                <p>{{ $allAppDetail->name }}</p>
                            </div>
                            <hr>
                            <div>
                                <p style="font-weight: 600;">Homepage url</p>
                                <p>{{ $allAppDetail->homepage_url }}</p>
                            </div>
                            <hr>
                            <div>
                                <p style="font-weight: 600;">App Token</p>
                                <p style="white-space: pre-wrap; word-wrap: break-word;">{{ $allAppDetail->api_token }}</p>
                            </div>
                            <hr>
                        </div>
                    @endforeach  
                </div>    
            </div>    
        </div>

        <div class="col s4">
            <div id="main-two-apps">
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