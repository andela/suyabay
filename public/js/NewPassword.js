$(document).ready(function(){
    $.ajaxSetup({ headers: { 'X-CSRF-Token': $('meta[name=_token').attr('content')} });
    $('#new_password_form').on('submit', function(){
        var url   =  "/password/resetGetEmail";
        var email = $('#email').val();
        var token = $('#token').val();
        var newPassword = $("#password_confirmation").val();
        var oldPassword = $("#password").val();
        var msg = "loading...";
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
            $.post(data.url, data.parameter)
            .done( function (response)
            {
                    alert('done');
                // }
            })
            .fail( function (response) {
                // swal('this action is bad');
            });
        return false;

    });




});

