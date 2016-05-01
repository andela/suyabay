        <!-- top nav -->
    @include("api.includes.sections.top_nav")

    <div class='row'>
        <div class="col m8">
            <div class="app-detail-one">
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

                    <p class="app-name">{{ $appDetails->name }}</p>

                    <a class="waves-effect waves-light btn" style="float: left; margin: 2% auto 4% 40%" href="/developer/myapp/{{ $appDetails->id }}/edit">Edit</a>
                </div>

                <div class='app-details'>
                    <div class = "row app" >
                        <div>Owner</div>
                        <div> {{ auth()->User()->username }} </div>
                    </div>
                    
                    <div class = "row app">
                        <div>Homepage url</div>
                        <div> <a href="{{ $appDetails->homepage_url }}" target="_blank">{{ $appDetails->homepage_url }}</a></div>
                    </div>
                    
                    <div class = "row app">
                        <div>App Token</div>
                        <div>
                            <input type="text" readonly class='input form-control token-box' id="token-box" value="{{ $appDetails->api_token }}"/>
                        <button class="waves-effect waves-app btn-copy copy" data-clipboard-target="#token-box" id="copy">
                            <i class="fa fa-clipboard active" aria-hidden="true"></i>
                        </button>
                        </div>
                        
                    </div>
                </div>
                </div>
            </div>
           <div class="col m4">
          <div class="app-detail-two">
                <div class="input-field col s10">
                    <a class="waves-effect waves-dark btn" style="width: 100%; margin-left: 10%;" href="{{ route('developer.new-app') }}">Create a new app</a>
                </div> 
                <div class="input-field col s10">
                    <a class="waves-effect waves-dark btn" style="width: 100%; margin-left: 10%;" href="{{ route('developer.index') }}">Developer</a>
                </div>
                <div class="input-field col s10">
                    <a class="waves-effect waves-dark btn" style="width: 100%; margin-left: 10%;" href="{{ route('developer.myapp') }}">My Apps</a>
                </div>
            </div>
        </div>  
    </div>

