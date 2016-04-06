@if ( Auth::check() )

    <!-- top nav -->
	@include("api.includes.sections.top_nav")
		<div class='row'>	
			<div id='main-one'>
				<h1>Your App Info<h1>

					@foreach ($app_infos as $app_info)
						<p>{{ $app_info->name }}</p>
						<p>{{ $app_info->homepage_url }}</p>
						<p>{{ $app_info->description }}</p>

					@endforeach
			</div>
		</div>
@else 

    <!-- top nav -->
        @include("api.includes.sections.top_nav")

    <!--auth check error page -->    
        @include("api.includes.contents.autherrorpage")

@endif		