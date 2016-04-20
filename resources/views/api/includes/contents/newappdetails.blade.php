        <!-- top nav -->
    @include("api.includes.sections.top_nav")

    <div class="row">
        <div class="col s8">
            <div id="main-one-app">
                @if(session()->has('info'))
                <div class="row">
                    <script>
                        swal({
                            title: 'Success',
                            text: '{!! session()->get("info") !!}',
                            timer: 2000,
                            showConfirmButton: false
                        })
                    </script>
                </div>
                @endif
                <div class='row'>
                    <p style=" margin-top: 15px;"class="app-name">{{ $appDetail->name }}</p>
                    <a class="wavesapp waves btn" href="#">Edit app</a>
                </div>

                <div class='app-details'>
                    <div class = "row app" >
                        <div>Owner</div>
                        <div> {{ auth()->User()->username }} </div>
                    </div>
                    
                    <div class = "row app">
                        <div>Homepage url</div>
                        <div> <a href="{{ $appDetail->homepage_url }}" target="_blank">{{ $appDetail->homepage_url }}</a></div>
                    </div>
                    
                    <div class = "row app">
                        <div>App Token</div>
                        <div>{{ $appDetail->api_token }}</div>
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
                    <a class="waves-effect waves-one btn" href="{{ route('developer.index') }}">Developer</a>
                </div>
                 <div class="session-three">

                </div>
            </div>
        </div>
        </div>
    </div>
