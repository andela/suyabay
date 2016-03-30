<!-- top nav -->
        <div class="row">
            @include("api.includes.sections.top_nav")
        </div>

<div id="hero" class="index_bg_container">
    <div id="overlay-image">
                
    </div>

    <div id="hero-content">
        <div class='content'>
            <h2 class="slider-text-header">Suyabay For Developers</h2>
            <p class="slider-text-paragraph">
                Whether you’re building a business on Suyabay or want to enhance your app with our podcast, 
                a rich set of Suyabay APIs can bring your products to life
            </p>
         </div>
    </div>

    <div class="menu">
        <nav id="hero-menu">
            <a class="class" href="/developer">Developer</a>
            <a href="http://suyabay.readthedocs.org/en/latest/">Docs</a>
            <a href="/developer/partners">Partners</a>
            <a href="/developer/myapp">MyApp</a>
        </nav>  
    </div> 
</div>

<!-- content -->
<div class="row">

    <div class="feature-content">
        <div class="text-content"> 
            <h1><a href="developer/myapp">MyApp</a></h1>
            <p>Check out your amazing apps that were built using Suyabay’s APIs..</p>
            <img  src ="{{ load_asset('images/apiimage4.png') }}">
        </div>
    </div>

    <div class="feature-content">
        <div class="text-content"> 
            <h1><a href="/developer/partners">Partners</a></h1>
            <p>Check out our suppporters and partners.</p>
            <img  src ="{{ load_asset('images/apiimage.png') }}">
        </div>
    </div>

    <div class="feature-content">
            <div class="text-content"> 
                <h1><a href="suyabay.readthedocs.org">Docs</a></h1>
                <p>See how Suyabay’s APIs work in action and find inspiration to create your next big thing.</p>
                <img  src ="{{ load_asset('images/apiimage2.png') }}">
            </div>
    </div>

</div>
