<div class="navbar-fixed">
    <nav role="navigation">
        <div class="nav-wrapper" style="background-color: #2C3E50;">

            <!-- Desktop view top nav -->

            <a href="/" class="logo" id="logo-container">suyabay</a>

            <ul class="right hide-on-med-and-down">
                <li>
                    <form action="/search" method="POST">
                    {{ csrf_field() }}

                        <div class="input-field">

                            <input name = "data" id="search" type="search" class="navbar-search" required>

                            <label for="search">

                                <i class="material-icons teal-text text-lighten-2">search</i>

                            </label>

                            <i class="material-icons">close</i>

                        </div>

                    </form>
                </li>

                <li>
                    
                    @if (  Auth::check() )
                    <a class="waves-effect" href="#">{{Auth::user()->username}}</a>
                    <a class="waves-effect waves-light modal-trigger" href="/logout">Logout</a>
                    @else
                    <a class="waves-effect modal-trigger" href="{{ URL::to('login') }}">SIGN IN</a>
                    <a class="waves-effect waves-light modal-trigger" href="{{ URL::to('signup') }}">SIGN UP</a>
                    @endif
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
