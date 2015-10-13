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
          case "passwordReset" : passwordResetErrorAlert(); break;
        }
    }
    else if ( functionName == 'passwordReset' )
    {
        passwordResetsAlert(data)
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
    $.post( data.url, data.parameter)
    .done(function(response)
    {
      ajaxLogic( data, response, functionName );
    })
    .fail(function(response) {
      console.log('this action is bad')
    })
}

/*
| RegisterSuccessAlert
| gives Success report to user
| receives 1 parameter
*/
function passwordResetsAlert (data)
{
  swal("Email reset has been sent to your email address");
}

/*
| RegistrErrorAlert
| gives error report to user
| receives 1 parameter
*/
function passwordResetErrorAlert ()
{
  swal("Ooops!!!", "Email address does not exit", "error")
}


/*
| register
| create user information and url in to an array of object i.e @data
| and make and ajax class to function ajaxCall() by sending @data and @functionName
*/
function passwordReset ()
{
  var url       = "/password/email";
  var email     = $('#email').val();
  var token     = $('#token').val();

  var data =
    {
        url         : url,
        parameter   :
        {
          _token      : token,
          email       : email
        }
    }
  var functionName =  arguments.callee.name;
  ajaxCall( data, functionName );
}