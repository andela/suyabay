<nav>
  <div class="nav-wrapper">

   <!-- Desktop view top nav -->
    <a href="#" class="brand-logo ">Logo</a>

    <ul class="right hide-on-med-and-down">
      <li><a href="sass.html"><i class="material-icons">add_alert</i></a></li>
      <li>
       <i class="large material-icons circle">person_pin</i>
      </li>

      <!-- Dropdown Trigger -->
      <li>
        <a class="waves-effect modal-trigger" href="#signin">SIGN IN</a>
        <a class="waves-effect waves-light modal-trigger" href="#signup">SIGN UP</a>
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
    <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>

  </div>
</nav>

<!-- Modal Structure -->

<!-- signup modal-->
  <div id="signup" class="modal">
    <div class="modal-content">
     <div class="row">
    <form class="col s12">
      <div class="row">
      <div class="input-field col s12">
      <i class="material-icons prefix">account_circle</i>
          <input id="last_name" type="text" class="validate" placeholder="e.g. snakeMonkeyDuh">
          <label for="last_name">Username</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
        <i class="material-icons prefix">mail</i>
          <input id="email" type="email" class="validate" placeholder="e.g. johnsnow@example.com">
          <label for="email">Email</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
        <i class="material-icons prefix">vpn_key</i>
          <input id="password" type="password" class="validate" placeholder="********">
          <label for="password">Password</label>
        </div>
      </div>
    </form>
  </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn">Create my account <i class="material-icons right">send</i></a>
    </div>
  </div>

<!-- signin modal-->
  <div id="signin" class="modal">
    <div class="modal-content">
     <div class="row">
    <form class="col s12">
      <div class="row">
      <h2>Hello, sparky!</h2>
      <div class="input-field col s12">
      <i class="material-icons prefix">account_circle</i>
          <input id="last_name" type="text" class="validate" placeholder="e.g. snakeMonkeyDuh">
          <label for="last_name">Username</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
        <i class="material-icons prefix">vpn_key</i>
          <input id="password" type="password" class="validate" placeholder="********">
          <label for="password">Password</label>
        </div>
      </div>

    </form>
  </div>
    </div>
    <div class="modal-footer">
      <a href="#reset" class="modal-action modal-trigger modal-close waves-effect waves-white btn-flat">Forgot password?</a>
      <a href="" class="modal-action modal-close waves-effect waves-white btn">SIGN IN <i class="material-icons right">send</i></a>
    </div>
  </div>

  <!-- passsword reset modal-->
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
    <div class="modal-footer">
       <a href="" class="modal-action modal-close waves-effect waves-white btn">reset <i class="material-icons right">send</i></a>
    </div>
  </div>
<script>
  $(document).ready(function(){
       $('.modal-trigger').leanModal();
  });
</script>

