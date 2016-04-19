@if ( Auth::check() )

        <!-- top nav -->
    @include("api.includes.sections.top_nav")

    <div class='row'>
    	<div class="col s8">
        	<div id="main-new-one">

	    		<div class='form-feature'>

			    	<form class action="/developer/myapp/new/" method="POST">

			    	<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
			    		<div class='form-content'>
			    		<h4 style='text-align: center;'>Create new App</h4>
				    		<h5>Application name</h5>

					    		<div class='form-group'>
					    			<input name='name' class='form-control' value="{{ old('name') }}">
					    		</div>	
					    		@if ($errors->has('name'))
                        			<span class="help-block">{{ $errors->first('name') }}</span>
                    			@endif

				    		<h5 class='new-app-text'>Home page url</h5>

					    		<div class='form-group'>
					    			<input name='homepage_url' class='form-control' value="{{ old('homepage_url') }}">
					    		</div>
					    		@if ($errors->has('homepage_url'))
                        			<span class="help-block">{{ $errors->first('homepage_url') }}</span>
                    			@endif			   			    

				    		<h5 class='new-app-text'>Application Description</h5>
				   
					    		<div class='form-group'>
					    			<textarea name='description' class='form-control'> </textarea>
					    		</div>
					    		@if ($errors->has('description'))
                        			<span class="help-block">{{ $errors->first('description') }}</span>
                    			@endif

					    	<div class='form-group'>
					    		<button type='submit' class="waves-effect wave btn">Create App</button>
					    	</div>	
				    	</div>
		    		</form>
	    		</div>
	    	</div>
	    </div>  
	    <div class="col s4">
            <div id="main-new-two">
                <div class="session-one">
                    <a type="submit" class="waves-effect wave btn" href={{ "route(developer.index" }}">Developer</a>
                </div> 
                <div class="session-two">

                </div>
                 <div class="session-three">

                </div>
            </div>  
        </div>
    </div>  

@else 

    <!--auth check error page -->    
        @include("api.includes.contents.autherrorpage")

@endif    