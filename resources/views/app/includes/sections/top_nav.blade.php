
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
                    <a class="waves-effect" href="login">SIGN IN</a>
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

