@if ( Auth::check() )

        <!-- top nav -->
    @include("api.includes.sections.top_nav")

    <div class='row'>
    	<div class="col s8">
        	<div id="main-new-one">
	    		<div class='form-feature'>
<<<<<<< HEAD
			    	<form class action="/developer/myapp/new/" method="POST">
=======
			    	<form method="POST">
>>>>>>> staging
			    	<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
			    		<div class='form-content'>
				    		<h5>Application name</h5>

					    		<div class='form-group'>
<<<<<<< HEAD
					    			<input name='name' class='form-control' value="{{ old('name') }}">
					    		</div>	
					    		@if ($errors->has('name'))
                        			<span class="help-block">{{ $errors->first('name') }}</span>
                    			@endif
=======
					    			<input name='application_name' class='form-control' value="{{ old('application_name') }}">
					    		</div>	
>>>>>>> staging

				    		<h5 class='new-app-text'>Home page url</h5>

					    		<div class='form-group'>
					    			<input name='homepage_url' class='form-control' value="{{ old('homepage_url') }}">
<<<<<<< HEAD
					    		</div>
					    		@if ($errors->has('homepage_url'))
                        			<span class="help-block">{{ $errors->first('homepage_url') }}</span>
                    			@endif			   			    
=======
					    		</div>				   			    
>>>>>>> staging

				    		<h5 class='new-app-text'>Application Description</h5>
				   
					    		<div class='form-group'>
<<<<<<< HEAD
					    			<textarea name='description' class='form-control'> </textarea>
					    		</div>
					    		@if ($errors->has('description'))
                        			<span class="help-block">{{ $errors->first('description') }}</span>
                    			@endif
=======
					    			<textarea name='application_description' class='form-control'> </textarea>
					    		</div>	
>>>>>>> staging

					    	<div class='form-group'>
					    		<button type='submit' class="waves-effect wave btn">Save Changes</button>
					    	</div>	
				    	</div>
		    		</form>
	    		</div>
	    	</div>
	    </div>  
	    <div class="col s4">
            <div id="main-new-two">
                <div class="session-one">
                    
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

    <!--auth check error page -->    
        @include("api.includes.contents.autherrorpage")

@endif    