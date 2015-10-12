/*
| Script By Emeke Osuagwu
| Description
|
*/

  function successAlert (data) 
  {
    swal({
      title: data.username + " Your SuyaBay account has be successfully created",
      text: "Send Email Confirmation",
      type: "success",
      showCancelButton: true,
      closeOnConfirm: false,
      showLoaderOnConfirm: true,
    },
    function(){
      setTimeout(function(){
        swal("Email Confirmation sent to " + data.email);
      }, 2000);
    });
  }
  function errorAlert (data) 
  {
    swal("Opps Registration Failed", "Username or Email already exists click the button to try again!", "error")
  }

  function register() 
  { 
    var email     = $('#email').val();
    var token     = $('#token').val();   
    var username  = $('#username').val();
    var password  = $('#password').val();   
    
    var data = 
    {
        _token      : token,
        email       : email,
        username    : username,
        password    : password
    }


    $.post( "signup", data)
    .done(function(response) 
    {
        if ( response.status_code !== 401) 
        {
            successAlert(data)   
        }
        else
        {
          errorAlert(data)   
        }

    })
    .fail(function(response) {
      //successAlert(data)
      console.log(response)
    })
  }       