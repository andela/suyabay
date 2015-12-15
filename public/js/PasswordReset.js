/*
| ajaxLogic
| Process ajaxCall data and return feedback base on the data
| receives 3 parameter from ajaxClass
| @data is the array of user infomation \\console.log(data) to see properties
| @response is the ajax response coming from the api end ponit
| @funtionName is the name of the fuction called
*/
function passwordResetAjaxLogic ( data, response, functionName )
{
    if ( response.status_code == 401)
    {
        switch (functionName)
        {
            case 'passwordReset' : passwordResetErrorAlert(); break;
        }
    }
    else if ( functionName == 'passwordReset' )
    {
        passwordResetsAlert();
    }
    else
    {
        window.location='/';
    }
}


/*
| ajaxCall
| send an ajax post request to the api end post
| receives 2 parameter from passwordReset function
| @data is the array of user infomation \\console.log(data) to see properties
| @funtionName is the name of the fuction called
|*/
function passwordResetAjaxCall ( data, functionName )
{
    $.post( data.url, data.parameter)

    .done( function (response)
    {
        passwordResetAjaxLogic( data, response, functionName );
    })
    .fail( function (response) {
        swal('this action is bad');
    });
}

/*
| passwordResetsAlert
| gives Success report to user
| receives 1 parameter
*/
function passwordResetsAlert ()
{
    //show modal and redirect
    swal({
            title: 'Done',
            text: 'Password reset link has been sent to your email address',
            type: 'success',
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
        function (){
            document.location.href = '/';
        }
    );
}

/*
| passwordResetErrorAlert
| gives error report to user
| receives 1 parameter
*/
function passwordResetErrorAlert ()
{
    swal('Ooops!!!', 'Email address does not exit', 'error');
}

/*
| passwordReset
| create user information and url in to an array of object i.e @data
| and make and ajax class to function ajaxCall() by sending @data and @functionName
*/
function passwordReset ()
{
  var url   = '/password/email';
  var email = $('#email').val();
  var token = $('#token').val();

  var data =
    {
        url        : url,
        parameter  :
        {
            _token : token,
            email  : email
        }
    }
  var functionName =  arguments.callee.name;
  passwordResetAjaxCall( data, functionName );
}

/*
| Process form on form submit
 */
$(document).ready( function (){
    $('#password_reset_form').on('submit', function (){
        swal({
            title: '',
            text: 'Processing request.',
            showConfirmButton: false
        });
        passwordReset();
        return false;
    });
});