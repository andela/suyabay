/**
 * checkPassword: check if the two password fiedls are thesame
 * @param  {string} password
 * @param  {string} password_confirmation
 * @return {boolean}
 */
function checkPassword(password, password_confirmation){
    if( password === password_confirmation )
    {
        return true;
    }
    else
    {
        passwordNotError();
    }
}

function passwordNotError()
{
    swal("Error", "Password does not match", "error");
}

/**
 * passwordLength: check the length of the password
 * @param  {string} password
 * @return {boolean}
 */
function passwordLength(password)
{
    if(password.length >= 6)
    {
        return true;
    }
    else
    {
        passwordLengthError();
    }
}

/**
 * passwordLengthError: Error message
 * @return {string} modal
 */
function passwordLengthError()
{
    swal("Error", "Password must be Six characters or more", "error");
}

/**
 * postSuccess: Recieves the ajax post request
 * @param  {int} response
 * @return {string} modal
 */
function postSuccess (response) {
    if(response == 401){
        swal("Error", "Error Processing request!!!", "error");
    }else{
        swal({
            title: "Done",
            text: "Password updated successfully",
            type: "success",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            },
            function (){
                document.location.href = "/login";
            }
        );
    }
}

/**
 * postFailError: Error message
 * @return {string} modal
 */
function postFailError () {
    swal("Error", "Error Processing request", "error");
}

/**
 * postPasswordReset: Sends the ajax post request
 * @param  {string} url
 * @param  {string} parameter
 * @return {string} modal
 */
function postPasswordReset(url, parameter)
{
    $.post(url, parameter)
    .done( function (response)
    {
        postSuccess(response.status_code);
    })
    .fail( function (response) {
        postFailError();
    });
}

$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            "X-CSRF-Token": $("meta[name=_token").attr("content")
        }
    });

    $("#new_password_form").on("submit", function(){
        swal("Proccessing Request!");
        var url   =  "/password/resetGetEmail";
        var email = $("#email").val();
        var token = $("#token").val();
        var newPassword = $("#password_confirmation").val();
        var oldPassword = $("#password").val();
        var data =
            {
                url        : url,
                parameter  :
                {
                    token  : token,
                    email   : email,
                    password: oldPassword,
                    password_confirmation:newPassword
                }
            }

            //check if password is thesame
            if(checkPassword(oldPassword, newPassword))
            {
                //check the stringlength of the password
                if (passwordLength(newPassword))
                {
                    //process ajax request
                    postPasswordReset(data.url, data.parameter);
                }
            }

        return false;
    });
});
