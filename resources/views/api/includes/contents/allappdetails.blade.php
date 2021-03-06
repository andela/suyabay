<!-- top nav -->
    @include("api.includes.sections.top_nav")

    <div class="row">
        <div class="col m8">
            @if(session()->has('info'))
                
                    <script>
                        swal({
                            title: 'status',
                            text: '{!! session()->get("info") !!}',
                            timer: 2000,
                            showConfirmButton: false
                        })
                    </script>
            @endif

                <div class="myapps-one">
                    <h5 class="app-title" style="font-size: 28px; margin-bottom: 2%">My Apps</h5>
                    @foreach($allApps as $app)

                        <div class='all-app-details'>
                            <div class="app-logo">
                                <img style="margin-left: -100px; margin-top: -50px;" class="" src="{!! load_asset('/css/logo.png') !!}" class="logo" />
                            </div>
                        
                            <div class="row">
                                <a style="font-size: 20px;" href="/developer/myapp/{{ $app->id }}">{{ $app->name }}</a>
                                <p style="font-size: 15px; margin-top: -5px;">{{ $app->description }}</p>
                            </div>    
                        </div>
                    @endforeach  
                </div>  
                <div class="button-details">
                   {!! $allApps->render() !!}
                </div> 
        </div>

        <div class="col m4">
          <div class="myapps-two">
            <div class="input-field col s10">
                <a class="waves-effect waves-dark btn" style="width: 100%; margin-left: 10%;" href="{{ route('developer.new-app') }}">Create a new app</a>
            </div> 
            <div class="input-field col s10">
                <a class="waves-effect waves-dark btn" style="width: 100%; margin-left: 10%;" href="{{ route('developer.index') }}">Developer</a>
            </div>
            </div>
        </div>  
    </div>