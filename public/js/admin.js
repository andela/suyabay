$(document).ready(function(){

    /**
     * onClick event to handle Channel delete
     */
    $(".delete_channel", this).on("click", function () {
        var id    = $(this).data("id");
        var url   = "/dashboard/channel/"+id;
        var name  = $(this).data("name");
        var token = $(this).data("token");
        var data  =  {
            url : url,
            parameter: {
                _token       : token,
                channel_id   : id,
                channel_name : name
            }
        }
        confirmDelete(data.url, data.parameter, data.parameter.channel_name );

        return false;
    });

    /**
     * onSubmit event to handle Channel creation
     */
    $("#create_channel").submit( function () {
        var url = "/dashboard/channel/create";
        var token               = $("#token").val();
        var channel_name        = $("#name").val();
        var channel_description = $("#description").val();
        var data =
            {
                url        : url,
                parameter  :
                {
                    _token        : token,
                    name          : channel_name,
                    description   : channel_description
                }
            }
        processAjax("POST", data.url, data.parameter, data.parameter.channel_name );

        return false;
    });

    /**
     * onSubmit event to handle Channel update
     */
    $("#channel_update").submit( function () {
        var url                 = "/dashboard/channel/edit";
        var token               = $("#token").val();
        var channel_id          = $("#channel_id").val();
        var channel_name        = $("#channel_name").val();
        var channel_description = $("#channel_description").val();
        var data =
            {
                url        : url,
                parameter  :
                {
                    _token                : token,
                    channel_id            : channel_id,
                    channel_name          : channel_name,
                    channel_description   : channel_description
                }
            }
        processAjax("PUT", data.url, data.parameter, data.parameter.channel_name );

        return false;
    });

    /**
     * onSubmit event to handle User Edit
     */
    $("#create_user").submit( function () {
        var url       = "/dashboard/user/create";
        var token     = $("#_token").val();
        var username  = $("#username").val();
        var user_role = $("#user_role").val();
        var data =
            {
                url        : url,
                parameter  :
                {
                    _token      : token,
                    username    : username,
                    user_role   : user_role
                }
            }
        processAjax("POST", data.url, data.parameter, data.parameter.username );

        return false;
    });

    /**
     * onSubmit event to handle User Edit
     */
    $("#edit_user").submit( function () {
        var url       = "/dashboard/user/edit";
        var token     = $("#_token").val();
        var user_id   = $("#user_id").val();
        var username  = $("#username").val();
        var user_role = $("#user_role").val();
        var data =
            {
                url        : url,
                parameter  :
                {
                    _token      : token,
                    user_id     : user_id,
                    username    : username,
                    user_role   : user_role
                }
            }
        processAjax("PUT", data.url, data.parameter, data.parameter.username );

        return false;
    });

});

/**
 *confirmDelete modal message
 *
 * @param  url
 * @param  parameter
 * @param  name
 */
function confirmDelete (url, parameter, name)
{
    swal({
        title: "Delete "+ name +"?",
        text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel plx!",
        closeOnConfirm: false,
        closeOnCancel: false
    },
    function ( isConfirm )
    {
        if( isConfirm ) {
            processAjax("DELETE", url, parameter, name);
        } else {
            cancelDeleteMessage( name );
        }
    });
}

/**
 * channelSuccessMessage modal message
 *
 * @param  name
 */
function channelSuccessMessage (message)
{
    swal({
            title: "Done!",
            text: message,
            type: "success",
            showCancelButton: false,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            },
            function (){
                document.location.href = "/dashboard/channels";
            }
        );
}

/**
 * successEditUser modal message
 */
function userSuccessMessage (message)
{
    swal({
            title: "Done!",
            text: message,
            type: "success",
            showCancelButton: false,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            },
            function (){
                document.location.href = "/dashboard/users";
            }
        );
}

/**
 * cancelDeleteMessage modal message
 *
 * @param  name
 */
function cancelDeleteMessage (name)
{
    swal("Cancelled", "Channel " + name + " is still available", "error");
}

/**
 * errorInviteUser modal message
 */
function errorMessage (message)
{
    swal("Error", message, "error");
}

/**
 * processAjax Proccess the ajax call
 *
 * @param  url
 * @param  parameter
 * @param  name
 */
function processAjax (action, url, parameter, name)
{

    $.ajax({
        url: url,
        type: action,
        data: parameter,
        success: function(response) {
            switch( response.status_code )
            {
                case 200:
                    return channelSuccessMessage( response.message );
                    break;

                case 201:
                    return userSuccessMessage( response.message );
                    break;

                default: errorMessage( response.message );
            }
        }
    });
}
