<div class="navbar-fixed">
    <nav role="navigation">
        <div class="nav-wrapper">
            <!-- Desktop view top nav -->
            <a href="/" id="logo-container">
                <img src="{!! load_asset('/css/logo.png') !!}" class="logo" />
            </a>
            <ul class="right hide-on-med-and-down">
                <li id="search">
                    @include('app.includes.contents.searchform')
                </li>
                <li>
                    @if (  Auth::check() )
                        <ul id="settings" class="dropdown-content">
                            <li><a href="{{ URL::to('profile/edit') }}">Profile</a></li>
                            <li><a href="{{ URL::to('profile/changepassword') }}">Account</a></li>
                            <li><a class="waves-effect waves-light modal-trigger" href="{{ URL::to('logout') }}">Logout</a></li>
                        </ul>
                        <a class="waves-effect dropdown-button" href="#" data-activates="settings">
                            <img class="avatar" src="{!! asset(Auth::user()->getAvatar()) !!}"  onerror="this.src='http://www.gravatar.com/avatar/\'.md5(strtolower(trim($user->email))).\'?d=mm&s=500'" title="{{ ucwords(Auth::user()->username) }}">
                            &nbsp;

                            <span class="username"> {{ ucwords(Auth::user()->username) }}</span>
                            <i class="material-icons right">arrow_drop_down</i>
                        </a>
                        @if( Auth::user()->hasChannelNotifications())
                            <a class="waves-effect waves-light modal-trigger" href="{{ route('notifications') }}"> <span class="badge" id="notification-num">{{ Auth::user()->newChannelsCount() }} </span> New {{ str_plural('Channel', Auth::user()->newChannelsCount()) }}</a>
                        @endif
                        @if(Auth::user()->role_id == 3)
                            @if(Auth::user()->countUpgradeRequests())
                                <a class="waves-effect waves-light modal-trigger" href="{{ route('view-requests') }}"> <span class="badge" id="notification-num">{{ Auth::user()->countUpgradeRequests() }} </span> New {{  str_plural('Upgrade request') }}</a>
                            @endif
                        @endif
                        @can('see-dashboard', Auth::user()->role->name )
                            <a class="waves-effect" href="/dashboard">Admin Dashboard</a>
                        @endcan

                        @can( 'see-upgrade', Auth::user()->role->name )
                            <a class="waves-effect teal lighten-2" href=" {{ URL::to('request-premium') }}">Become a Premium User</a>
                        @endcan
                    @else
                    <a class="waves-effect modal-trigger" href="{{ URL::to('login') }}">Log In</a>
                    <a class="waves-effect waves-light modal-trigger" href="{{ URL::to('signup') }}">Sign Up</a>
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