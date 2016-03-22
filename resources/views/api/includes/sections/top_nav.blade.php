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
                </li>
            </ul>
            <a href="#" data-activates="nav-mobile" class="button-collapse">
                <i class="material-icons">menu</i>
            </a>
        </div>
    </nav>
</div>
