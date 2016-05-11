@include("api.includes.sections.top_nav")

    <div class="row">
        <div class="col m8">
            <div class="app-detail-one">
                <div class='row'>
                    <p class="col s8 app-name">{{ $appDetails->name }}</p>
                    <a class="col s4 waves-effect waves-light btn" style="float: left; margin: -9% auto 4% 79%; width: 20%;" href="/developer/myapp/{{ $appDetails->id }}/edit">Edit</a>
                </div>

                <div class="app-details-old">
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
                        <div><input type="text" readonly class='input form-control token-box' id="token-box" value="{{ $appDetails->api_token }}"/>
                        <button class="waves-effect waves-app btn-copy copy" data-clipboard-target="#token-box" id="copy">
                            <i class="fa fa-clipboard active" aria-hidden="true"></i>
                        </button>
                        </div>  
                    </div> 
                </div>
                <div class="input-field col s10">
                    <a data-id="{{ $appDetails->id }}" style="margin: -6% 1% 2% 96%; float: left; width: 25%" id="delete-api" class="waves btn" href="#">Delete</a>
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
