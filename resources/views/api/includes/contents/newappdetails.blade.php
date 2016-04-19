        <!-- top nav -->
    @include("api.includes.sections.top_nav")

    <div class="row">
        <div class="col s8">
            <div id="main-one-app">
                <div class='row'>
                    <p class="app-name">{{ $appDetails->name }}</p>
                    <a class="wavesapp waves btn" href="#">Edit app</a>
                </div>

                <div class='app-details'>
                    <div class='row'>
                        <p style="font-weight: 600;">Owner</p>
                        <p> {{ auth()->User()->username }} </p>
                    </div>
                    <hr>
                    <div class=>
                        <p style="font-weight: 600;">Homepage url</p>
                        <p>{{ $appDetails->homepage_url }}</p>
                    </div>
                    <hr>
                    <div class=>
                        <p style="font-weight: 600;">App Token</p>
                        <input type="text" readonly class='input form-control token-box' id="token-box" value="{{ $appDetails->api_token }}" />
                        <button class="waves-effect waves-app btn-copy copy" data-clipboard-target="#token-box" id="copy">
                            <i class="fa fa-clipboard active" aria-hidden="true"></i>
                        </button>
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
