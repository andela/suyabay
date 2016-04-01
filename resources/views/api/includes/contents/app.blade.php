@if ( Auth::check() )

        <!-- top nav -->
    @include("api.includes.sections.top_nav_user")

    <div class="row">
        <div class="col s8">
            <div id="main-one">
                <h5 class="app-title">My Apps</h5>
                <div class="myapp">
                    <p class="app-text">You haven't created any suyabay apps yet.</p>
                    <a class="waves-effect waves btn" href="/developer/myapp/register">Create a new app</a>   
                </div>    
            </div>    
        </div>

        <div class="col s4">
            <div id="main-two">
                <div class="session-one">
                    <a class="waves-effect waves-one btn" href="/developer/myapp/register">Create a new app</a>
                </div> 
                <div class="session-two">

                </div>
                 <div class="session-three">

                </div>
            </div>  
        </div>
    </div>

@else 

    <!-- top nav -->
        @include("api.includes.sections.top_nav")

    <div class="row">
        <div class="error-message">
            <h4 class="error-text">OOps, please kindly sign up if you don't already have an account or login otherwise, in order to view this page</h4>
            <div class="col s6">
                <a class="waves-effect waves-two btn" href="/login">Login here </a>
            </div>
            <div class="col s6">
                <a class="waves-effect waves-two btn" href="/signup">Sign up here</a>
            </div>
        </div>
    </div>

@endif