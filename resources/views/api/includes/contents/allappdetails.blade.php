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
                                <img style="margin-left: -100px;"src="{!! load_asset('/css/logo.png') !!}" class="logo" />
                            </div>
                        
                            <div>
                                <a style="font-size: 20px;" href="/developer/myapp/{{ $app->id }}">{{ $app->name }}</a>
                                <p style="font-size: 15px; margin-top: -5px;">{{ $app->description }}</p>
                            
                            </div>
                        
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