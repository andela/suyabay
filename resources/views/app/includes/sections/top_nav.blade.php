<div class="navbar-fixed">
    <nav role="navigation">
        <div class="nav-wrapper">

            <!-- Desktop view top nav -->

            <a href="/" id="logo-container">
                <img src="{!! load_asset('/css/logo.png') !!}" class="logo" />
            </a>
            <ul class="right hide-on-med-and-down">
                <li>
                    <form action="{{ route('searchsuya') }}" role="search">

                        <div class="input-field">
                            <input name = "query" id="query" type="search" class="search" required>
                            <label for="search">
                                <i class="material-icons teal-text text-lighten-2">search</i>
                            </label>
                            <button type="submit" style="display:none;" name="search">search</button>
                            <i class="material-icons">close</i>
                        </div>
                    </form>
                </li>

                <li>
                    @if (  Auth::check() )
                        <ul id="settings" class="dropdown-content">
                            <li><a href="/profile/edit">Profile</a></li>
                            <li><a href="/profile/changepassword">Account</a></li>
                        </ul>

                        <a class="waves-effect dropdown-button" href="#" data-activates="settings">
                        <img class="avatar" src="{!! asset(Auth::user()->getAvatar()) !!}"  onerror="this.src='http://www.gravatar.com/avatar/\'.md5(strtolower(trim($user->email))).\'?d=mm&s=500'">
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
