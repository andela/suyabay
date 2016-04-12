@if ( Auth::check() )

        <!-- top nav -->
    @include("api.includes.sections.top_nav")
    

@else 

	<!-- top nav -->
        @include("api.includes.sections.top_nav")

    <!--auth check error page -->    
        @include("api.includes.contents.autherrorpage")

@endif    