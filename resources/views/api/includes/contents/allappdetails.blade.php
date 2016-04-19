<!-- top nav -->
    @include("api.includes.sections.top_nav")

    <div class="row">
        <div class="col s8">
            <div id="main-one-apps">
                <h5 class="app-title" style="font-size: 30px;">My Apps</h5>
                <div class="myapps">
                    @foreach($allApps as $app)
                        <div class='all-app-details'>
                            <div class="app-name">
                                <p>{{ $app->name }}</p>
                            </div>
                            <hr>
                            <div>
                                <p style="font-weight: 600;">Homepage url</p>
                                <a href="{{ $app->homepage_url }}" target="_blank">{{ $app->homepage_url }}</a>
                            </div>
                            <hr>
                            <div>
                                <p style="font-weight: 600;">App Token</p>
                                <input type="text" readonly class='input form-control token-box' id="token-box" value="{{ $app->api_token }}" />
                                <button class="waves-effect waves-app btn-copy copy" data-clipboard-target="#token-box" id="copy">
                                    <i class="fa fa-clipboard active" aria-hidden="true"></i>
                                </button>
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
                    <a class="waves-effect waves-one btn" href="{{ route('developer.new-app') }}">Create a new app</a>
                </div> 
                <div class="session-two">
                <a class="waves-effect waves-one btn" href="{{ route('developer.index') }}">Developer</a>
                </div>
                 <div class="session-three">

                </div>
            </div>  
        </div>
    </div>