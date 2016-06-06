
    <!-- top nav -->
    @include("api.includes.sections.top_nav")

    <div class='row'>
    	<div class="col m8">
        	<div class="app-form">

          
	    		<div class='app-form-one'>

			    	<form id="app-update" action="/developer/myapp/edit" method="POST">
			    	<input type="hidden" value="{{ $appDetails->id }}" name="id" id="id" />
			    		<div class="row" style="margin-left: 10%;">
			    		<h4 style='text-align: center;'>Edit App</h4>
				    		<h5 class='new-app-text'>Application name</h5>

					    		<div class="input-field col s12">
					    			<input name='name' value="{{ $appDetails->name }}" id="name">
					    		</div>	

				    		<h5 class='new-app-text'>Home page url</h5>

					    		<div class="input-field col s12">
					    			<input name='homepage_url' value="{{ $appDetails->homepage_url }}" id="homepage_url">
					    		</div>
		
				    		<h5 class='new-app-text'>Application Description</h5>
				   
					    		<div class="input-field col s12">
					    			<textarea name='description' id="description">{{ $appDetails->description }}</textarea>
					    		</div>

					    	<div class="input-field col s3 ">
					    		<button type='submit' class="waves-effect waves-dark btn" >Edit</button>
					    	</div>
				    	</div>
		    		</form>
	    		</div>
	    	</div>
	    </div>  
		<div class="col m4">
            <div class="app-form-two">
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
 