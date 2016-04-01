<div class="row">
<div class="navbar-fixed">
    <nav role="navigation">
        <div class="nav-wrapper">

            <!-- Desktop view top nav -->

            <a href="/" id="logo-container">
                <img src="{!! load_asset('/css/logo.png') !!}" class="logo" />
            </a>
            <ul class="right hide-on-med-and-down">
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

                        <a class="waves-effect waves-light modal-trigger" href="/logout">Logout</a>
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
</div>
