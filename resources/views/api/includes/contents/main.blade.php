<!-- top nav -->
<div class="row">
    <div class="navbar-fixed">
    <nav role="navigation">
        <div class="nav-wrapper">

            <!-- Desktop view top nav -->

            <a href="/" id="logo-container">
                <img src="{!! load_asset('/css/logo.png') !!}" class="logo" />
            </a>
            <a href="#" data-activates="nav-mobile" class="button-collapse">
                <i class="material-icons">menu</i>
            </a>
        </div>
    </nav>
</div>
</div>

<div id="hero" class="index_bg_container">
    <div id="overlay-image">
                
    </div>

    <div id="hero-content">
        <div class='content'>
            <h3 class="slider-text-header" style="float: left;">Suyabay For Developers</h3>
            <p class="slider-text-paragraph" style="text-align: justify; float: left;">
                Whether you’re building a business on Suyabay or want to enhance your app with our podcast, 
                a rich set of Suyabay APIs can bring your products to life.
            </p>
         </div>
    </div>

    <div class="menu">
        <nav id="hero-menu">
            <a class="class" href="/developer">Developer</a>
            <a href="http://suyabay.readthedocs.org/en/latest/">Docs</a>
            <a href="/developer/partners">Partners</a>
            <a href="/developer/myapp">My Apps</a>
        </nav>  
    </div> 
</div>

<!-- content -->
<div class="row">

    <div class="feature-content">
        <div class="text-content"> 
            <h1><a href="developer/myapp">My Apps</a></h1>
            <p>Check out your amazing apps that were built using Suyabay’s APIs..</p>
            <img class="responsive-img" src ="{{ load_asset('images/apiimage4.png') }}">
        </div>
    </div>

    <div class="feature-content">
        <div class="text-content"> 
            <h1><a href="/developer/partners">Partners</a></h1>
            <p>Check out our suppporters and partners.</p>
            <img class="responsive-img" src ="{{ load_asset('images/apiimage.png') }}">
        </div>
    </div>

    <div class="feature-content">
            <div class="text-content"> 
                <h1><a href="suyabay.readthedocs.org">Docs</a></h1>
                <p>See how Suyabay’s APIs work in action and find inspiration to create your next big thing.</p>
                <img class="responsive-img" src ="{{ load_asset('images/apiimage2.png') }}">
            </div>
    </div>
</div>