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
          case "login": loginErrorAlert(data); break;
          case "runMe": runMe(); break;
        }
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

function register () 
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
  ajaxCall(data);
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