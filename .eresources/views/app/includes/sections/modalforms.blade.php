<!-- Modal Structure -->
<!-- Signup Modal-->
<form method="POST" action="{{ route('register') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div id="signup" class="modal">
        <div class="modal-content">
            <div class="row">
                <div class="col s12">
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input name = "username" id="last_name" type="text" class="validate" placeholder="e.g. snakeMonkeyDuh">
                            <label for="last_name">Username</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">mail</i>
                            <input name = "email" id="email" type="email" class="validate" placeholder="e.g. johnsnow@example.com">
                            <label for="email">Email</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">vpn_key</i>
                            <input name = "password" id="password" type="password" class="validate" placeholder="********">
                            <label for="password">Password</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- create account button-->
        <div class="modal-footer">
            <button class=" modal-action modal-close waves-effect waves-green btn">
                Create my account
                <i class="material-icons right">send</i>
            </button>
        </div>
    </div>
</form>

<!-- Login Modal-->
<form method="POST" action="{{ route('login') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div id="signin" class="modal">
        <div class="modal-content">
            <div class="row">
                <div class="col s12">
                    <div class="row">
                        <h2>Hello, sparky!</h2>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">account_circle</i>
                                <input name="username" id="last_name" type="text" class="validate" placeholder="e.g. snakeMonkeyDuh">
                                <label for="last_name">Username</label>
                            </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">vpn_key</i>
                            <input name="password" id="password" type="password" class="validate" placeholder="********">
                            <label for="password">Password</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Signin and forgot password buttons-->
        <div class="modal-footer">
            <a href="#reset" class="modal-action modal-trigger modal-close waves-effect waves-white btn-flat">Forgot password?</a>
            <button class="modal-action modal-close waves-effect waves-white btn">
                <i class="material-icons right">send</i>
                SIGN IN
            </button>
        </div>
    </div>
</form>

<!-- Passsword reset modal-->
<div id="reset" class="modal">
    <div class="modal-content">
        <div class="row">
            <form class="col s12">
                <div class="row">
                    <h2>Oops, sparky needs a password reset!</h2>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">mail</i>
                            <input id="email" type="text" class="validate" placeholder="e.g. johnsnow@example.com">
                            <label for="email">email</label>
                        </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Reset password button-->
    <div class="modal-footer">
        <a href="" class="modal-action modal-close waves-effect waves-white btn">reset
            <i class="material-icons right">send</i>
        </a>
    </div>
</div>
