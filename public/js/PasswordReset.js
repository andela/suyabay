$(document).ready(function(){
    $("#password_reset_form").on('submit', function(){
        var url = "/password/email";
        var serialize = $("#password_reset_form").serialize();
        var datas = function(e){
            swal($('#email').val());
        };
        $.post(url, serialize, datas);
    return false;
    });
});