
        <!-- top nav -->
    @include("api.includes.sections.top_nav")

    <div class='row'>
    	<div class="col m8">
        	<div class="app-form">

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
	    		<div class='app-form-one'>

			    	<form class="col s12" action="/developer/myapp/new/" method="POST">

			    		<div class="row" style="margin-left: 10%;">
			    		<h4 style='text-align: center;'>Create new App</h4>
				    		<h5 class='new-app-text'>Application name</h5>

					    		<div class="input-field col s12">
					    			<input name='name' value="{{ old('name') }}">
					    		</div>	
					    		@if ($errors->has('name'))
                        			<span class="help-block">{{ $errors->first('name') }}</span>
                    			@endif

				    		<h5 class='new-app-text'>Home page url</h5>

					    		<div class="input-field col s12">
					    			<input name='homepage_url' value="{{ old('homepage_url') }}">
					    		</div>
					    		@if ($errors->has('homepage_url'))
                        			<span class="help-block">{{ $errors->first('homepage_url') }}</span>
                    			@endif			   			    

				    		<h5 class='new-app-text'>Application Description</h5>
				   
					    		<div class="input-field col s12">
					    			<textarea name='description' > </textarea>
					    		</div>
					    		@if ($errors->has('description'))
                        			<span class="help-block">{{ $errors->first('description') }}</span>
                    			@endif

					    	<div class="">
					    		<button type='submit' class="waves-effect waves-dark btn" style="margin-left: 72%; float: left;">Create App</button>
					    	</div>	
				    	</div>
		    		</form>
	    		</div>
	    	</div>
	    </div> 

	       <div class="col m4">
               <div class="app-form-two">
                    <div class="input-field col s10">
                        <a class="waves-effect waves-dark btn" style="width: 100%; margin-left: 10%;" href="{{ route('developer.index') }}">Developer</a>
                    </div>
                    <div class="input-field col s10">
                        <a class="waves-effect waves-dark btn" style="width: 100%; margin-left: 10%;" href="{{ route('developer.myapp') }}">My Apps</a>
                    </div>
                </div>
            </div>
        </div>  
 