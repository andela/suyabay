/*
| Script By Emeke Osuagwu
| Description
|
*/

function ajaxLogic ( data, response, functionName ) 
{
    if ( response.status_code === 401) 
    {
        switch (functionName) 
        {
          case "login"    : loginErrorAlert(data); break;
          case "register" : RegistrErrorAlert(); break;
        }
    }
    else if ( functionName == 'register' )
    {
        RegisterSuccessAlert(data)
    }
    else
    {
      window.location="/";
    }
}

function ajaxCall ( data, functionName ) 
{
    console.log(data.url)
    $.post( data.url, data.parameter)
    .done(function(response) 
    {
      ajaxLogic( data, response, functionName );
    })
    .fail(function(response) {
      console.log('this action is bad')
    })
}

function loginErrorAlert (data) 
{
  swal("Opps Login Failed", "Username or Password not found!", "error")
}


function RegisterSuccessAlert (data) 
{
  swal({
    title: data.parameter.username + " Your SuyaBay account has be successfully created",
    text: "Send Email Confirmation",
    type: "success",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
    setTimeout(function(){
      swal("Email Confirmation sent to " + data.parameter.email);
    }, 2000);
  });
}

function RegistrErrorAlert () 
{
  swal("Opps Registration Failed", "Username or Email already exists click the button to try again!", "error")
}

function register () 
{ 
  var url       = "/signup";
  var email     = $('#email').val();
  var token     = $('#token').val();   
  var username  = $('#username').val();
  var password  = $('#password').val();   
  
  var data = 
    {
        url         : url,
        parameter   : 
        {
          _token      : token,
          email       : email,
          username    : username,
          password    : password   
        }
    }
  console.log(data)
  var functionName =  arguments.callee.name;  
  
  ajaxCall( data, functionName );
}

function login () 
{
    var url       = '/login';
    var email     = $('#email').val();
    var token     = $('#token').val();   
    var username  = $('#username').val();
    var password  = $('#password').val();   
    
    var functionName =  arguments.callee.name;  
    var data = 
    {
        url         : url,
        parameter   : 
        {
          _token      : token,
          username    : username,
          password    : password   
        }
    }
    ajaxCall( data, functionName ); 
}       