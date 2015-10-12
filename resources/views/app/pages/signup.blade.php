@extends('app.authlayout')

@section('title', 'Signup')

@section('content')

<script>    
// swal({
//   title: "Emeka",
//   text: "Your SuyaBay account has be successfully created.",
//   type: "success",
//   showCancelButton: true,
//   confirmButtonColor: "#DD6B55",
//   confirmButtonText: "Send Email Confirmation",
//   closeOnConfirm: false
// },
// function(){
//   swal("Sent", "Email Confirmation sent.", "success");
// });

swal({
  title: "Your SuyaBay account has be successfully created",
  text: "Send Email Confirmation",
  type: "success",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
},
function(){
  setTimeout(function(){
    swal("Email Confirmation sent");
  }, 2000);
});
 

</script>
<div class="row">

    <div class="col s3 hide-on-small-only white-text">
        void
    </div>

    <div class="col s12 m6 l6">

        <div class="center-align fix">

            <h2>SuyaBay Podcast</h2>
            <small>create your account</small>
        </div>

        <div class="row">
            <form class="col s12" method="POST" action="{{ route('register') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">mode_edit</i>
                            <textarea name="username" id="icon_prefix1" class="materialize-textarea"></textarea>
                            <label for="icon_prefix1">
                                Username
                            </label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">mode_edit</i>
                            <input name="email" id="email" type="email" class="validate">
                                <label for="email">Email</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">mode_edit</i>
                            <input name="password" id="password" type="password" class="validate">
                                <label for="password">Password</label>
                    </div>
                </div>

                <div class="row container">

                    <p class="left">
                        <input type="checkbox" class="filled-in" id="remember-me" checked="checked" />
                        <label for="remember-me">Remember Me</label>
                    </p>

                    <button class="waves-effect waves-light btn right">
                        Sign Up
                    </button>
                </div>
            </form>
        </div>

        <div class="row container">

            <span>
                <small>
                    Already a user?
                </small>
            </span>

            <span>
                <small>
                    <a href="{{ URL::to('signin') }}"> Sign In to your account</a>
                </small>
            </span>
        </div>
    </div>

    <div class="col s3 hide-on-small-only white-text">
        void
    </div>

</div>

@endsection
