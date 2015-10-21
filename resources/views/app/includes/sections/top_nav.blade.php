<<<<<<< HEAD
<div class="navbar-fixed">
    <nav role="navigation">
        <div class="nav-wrapper" style="background-color: #2C3E50;">
=======

<!-- User Drop Nav -->
<ul id="dropdown1" class="dropdown-content">
  <li><a href="#!">one</a></li>
  <li><a href="#!">two</a></li>
  <li class="divider"></li>
  <li><a href="#!">three</a></li>
</ul>

<nav>
    <div class="nav-wrapper">

        <!-- Desktop view top nav -->
        <a href="#" class="brand-logo title"> logo</a>

        <ul class="right hide-on-med-and-down">
            <li>
                <a href="#!">
                    <i class="material-icons">add_alert</i>
                </a>
            </li>
            <li>
                <a href="#!">
                    <i class="large material-icons circle">person_pin</i>
                </a>
            </li>
            <li>
                @if ( ! Auth::check() )
                    <a class="waves-effect modal-trigger" href="#signin">SIGN IN</a>
                    <a class='waves-effect waves-light modal-trigger'; href='#signup'>SIGN UP</a>
                @else
                    <a class="dropdown-button" href="#!" data-activates="dropdown1">
                        {{ Auth::user()->username }}
                        <i class="material-icons right">arrow_drop_down</i>
                    </a>
                @endif
            </li>
        </ul>

        <!-- Mobile view nav -->
        <ul id="nav-mobile" class="side-nav">
            <div class="col s12 m3">
                <div class="collection">
                    <a href="#!" class="collection-item active">My List</a>
                    <a href="#!" class="collection-item">Channels</a>
                    <a href="#!" class="collection-item">Favourites</a>
                </div>
            </div>
        </ul>

        <!-- Hambuger Mobile menu -->
        <a href="#" data-activates="nav-mobile" class="button-collapse">
            <i class="material-icons">menu</i>
        </a>
    </div>
</nav>
>>>>>>> initial commit for user registrationand authentication

            <!-- Desktop view top nav -->

            <a href="/" class="logo" id="logo-container"> suyabay</a>

            <ul class="right hide-on-med-and-down">
                <li>
                    <form action="/search" method="POST">
                    {{ csrf_field() }}
                        <div class="input-field">
                            <input id="search" type="search" class="navbar-search" required>
                                <label for="search">
                                    <i class="material-icons teal-text text-lighten-2">search</i>
                                </label>
                                <i class="material-icons">close</i>
                        </div>

                    </form>
                </li>

                <li>
                    <a class="waves-effect modal-trigger" href="{{ URL::to('signin') }}">SIGN IN</a>
                    <a class="waves-effect waves-light modal-trigger" href="{{ URL::to('signup') }}">SIGN UP</a>
                    <a class="waves-effect teal lighten-2" href="#!">Become a Premium User</a>
                </li>
            </ul>

            <ul id="nav-mobile" class="side-nav collection">

                <li class="collection-item">
                    <a href="#">CHANNELS <span class="new badge grey darken-2" style="padding:5px;">4</span></a>
                </li>

                <li class="collection-item">
                    <a href="#">FAVOURITES <span class="new badge grey darken-2" style="padding:5px;">0</span></a>
                </li>

                <li class="collection-item center-align">
                    <a href="{{ URL::to('search') }}">SEARCH</a>
                </li>

                <li class="collection-item">
                    <a href="{{ URL::to('signin') }}">SIGN IN</a>
                </li>

                <li class="collection-item">
                    <a href="{{ URL::to('signup') }}">SIGN UP</a>
                </li>

                <li class="collection-item">
                    <a href="{{ URL::to('about') }}">ABOUT</a>
                </li>

                <li class="collection-item">
                    <a href="{{ URL::to('faqs') }}">FAQs</a>
                </li>

                <li class="collection-item">
                    <a href="{{ URL::to('privacypolicy') }}">PRIVACY POLICY</a>
                </li>

            </ul>

            <a href="#" data-activates="nav-mobile" class="button-collapse">
                <i class="material-icons">menu</i>
            </a>
        </div>
    </nav>
</div>
