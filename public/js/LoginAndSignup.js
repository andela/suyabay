/*
| Script By Emeke Osuagwu @dev_emeka emekaosuagwuandela@gmail.com
| Description LoginAndSigup script in create to handel ajax call
| for Suyabay Login and Register funtionality and also and Email for
| user registeration.
*/



/*
| ajaxLogic
| Process ajaxCall data and return feedback base on the data
| receives 3 parameter from ajaxClass
| @data is the array of user infomation \\console.log(data) to see properties
| @response is the ajax response coming from the api end ponit
| @funtionName is the name of the fuction called
*/
function ajaxLogic ( data, response, functionName )
{
    if ( response.status_code === 401)
    {
        switch (functionName)
        {
          case "login"    : loginErrorAlert(); break;
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


/*
| ajaxCall
| send an ajax post request to the api end post
| receives 2 parameter from register function or login function
| @data is the array of user infomation \\console.log(data) to see properties
| @funtionName is the name of the fuction called
|*/
function ajaxCall ( data, functionName )
{
    $.post( window.location.hostname/data.url, data.parameter)
    .done(function(response)
    {
      ajaxLogic( data, response, functionName );
    })
    .fail(function(response) {
      console.log('this action is bad')
    })
}

/*
| loginErrorAlert
| gives error report to user
*/
function loginErrorAlert ()
{
  swal("Opps Login Failed", "Username or Password not found!", "error")
}

/*
| RegisterSuccessAlert
| gives Success report to user
| receives 1 parameter
*/
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

/*
| RegistrErrorAlert
| gives error report to user
| receives 1 parameter
*/
function RegistrErrorAlert ()
{
  swal("Opps Registration Failed", "Username or Email already exists click the button to try again!", "error")
}


/*
| register
| create user information and url in to an array of object i.e @data
| and make and ajax class to function ajaxCall() by sending @data and @functionName
*/
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
  checkItem(data);
  var functionName =  arguments.callee.name;
  ajaxCall( data, functionName );
}


/*
| login
| create user information and url in to an array of object i.e @data
| and make and ajax class to function ajaxCall() by sending @data and @functionName
*/
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
    checkItem(data);
    ajaxCall( data, functionName );
}

//console.log(window.location.hostname);
function checkItem (data)
{
      if  ( data.parameter.email == '' || data.parameter.username == '' || data.parameter.password == '' )
      {
        swal("Oppss Login Failed", "Some required field not set!", "error")
      }
}


alert('fhjdhfgjdhffjdfh')