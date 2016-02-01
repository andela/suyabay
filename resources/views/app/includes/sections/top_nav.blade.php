<div class="navbar-fixed">
    <nav role="navigation">
        <div class="nav-wrapper">

            <!-- Desktop view top nav -->

            <a href="/" id="logo-container">
                <img src="{!! asset('/css/logo.png') !!}" class="logo" />
            </a>
            <ul class="right hide-on-med-and-down">
                <li>
                    <form action="/search" method="POST">
                    {{ csrf_field() }}
                        <div class="input-field">
                            <input name = "data" id="search" type="search" class="search" required>
                            <label for="search">
                                <i class="material-icons teal-text text-lighten-2">search</i>
                            </label>
                            <i class="material-icons">close</i>
                        </div>
                    </form>
                </li>

                <li>
                    @if (  Auth::check() )
                        <ul id="settings" class="dropdown-content">
                            <li><a href="/profile/edit">Settings</a></li>
                            }
                        </ul>

                        <a class="waves-effect dropdown-button" href="#" data-activates="settings">
                        <img class="avatar" src="{!! asset(Auth::user()->getAvatar()) !!}">
                        &nbsp;
                        {{ Auth::user()->username }}<i class="material-icons right">arrow_drop_down</i></a>

                        @can('see-dashboard', Auth::user()->role->name )
                            <a class="waves-effect" href="/dashboard">Admin Dashboard</a>
                        @endcan

                        <a class="waves-effect waves-light modal-trigger" href="/logout">Logout</a>

                        @can( 'see-upgrade', Auth::user()->role->name )
                            <a class="waves-effect teal lighten-2" href="#">Become a Premium User</a>
                        @endcan

                    @else
                        <a class="waves-effect modal-trigger" href="{{ URL::to('login') }}">Log In</a>
                        <a class="waves-effect waves-light modal-trigger" href="{{ URL::to('signup') }}">Sign Up</a>
                        <a class="waves-effect teal lighten-2" href="{{ URL::to('signup') }}">Become a Premium User</a>
                    @endif
                </li>
            </ul>
            @yield('mobile-nav')
            <a href="#" data-activates="nav-mobile" class="button-collapse">
                <i class="material-icons">menu</i>
            </a>
        </div>
    </nav>
</div>
