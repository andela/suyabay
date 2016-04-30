        <!-- top nav -->
    @include("api.includes.sections.top_nav")

    <div class="row">
       <div class="col m8">
            <div class="myapp-one">
                <h5 class="app-title">My Apps</h5>
                <div class="myapp">
                    <p class="app-text">You haven't created any suyabay app yet.</p>
                    <a class="waves-effect waves-dark btn" style="width: 70%; margin-left: 10%;" href="{{ route('developer.new-app') }}">Create a new app</a>   
                </div>    
            </div>    
        </div>

        <div class="col m4">
          <div class="myapp-two">
            <div class="input-field col s10">
                <a class="waves-effect waves-dark btn" style="width: 100%; margin-left: 10%;" href="{{ route('developer.new-app') }}">Create a new app</a>
            </div> 
            <div class="input-field col s10">
                <a class="waves-effect waves-dark btn" style="width: 100%; margin-left: 10%;" href="{{ route('developer.index') }}">Developer</a>
            </div>
            </div>
        </div>  
    </div>