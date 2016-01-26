$(document).ready(function(){

    /**
     * onClick event to handle Channel delete
     */
    $("#delete_channel", this).on("click", function () {
        var id      = $(this).data("id");
        var url     = "/dashboard/channel/"+id;
        var token   = $(this).data("token");
        var name    = $(this).data("name");
        var data    =  {
            url : url,
            parameter: {
                _token       : token,
                channel_id   : id,
                channel_name : name
            }
        }
        confirmDelete(data.url, data.parameter, data.parameter.channel_id, data.parameter.channel_name );

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
     * onSubmit swap channels
     */
    $("#swap_episodes").submit( function () {
        var id      = $("#channel_id").val();
        var url     = "/dashboard/channel/swap/"+id;
        var new_channel_id = $("#new_channel_id").val();
        var token   = $("#token").val();
        var data    =
            {
                parameter  :
                {
                    _token        : token,
                    channel_id              : id,
                    new_channel_id          : new_channel_id
                }
            }

        processAjax("POST", url, data.parameter, data.parameter.new_channel_id);

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
function confirmDelete (url, parameter, id, name)
{
    swal({
        title: "Confirm Delete",
        text: "If this Channel has Episodes, deleting it implies deleting all the Episodes under it. You can swap it's episodes to another Channel or go ahead and just delete it.",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#009688",
        confirmButtonText: "Swap & Delete",
        cancelButtonText: "Just Delete it!",
        allowOutsideClick:true,
        closeOnConfirm: false,
        closeOnCancel: false,
        animation:true,
        showLoaderOnConfirm:true

    },

    function ( isConfirm )
    {
        if ( isConfirm) {
            document.location.href = "/dashboard/channel/swap/"+id;    
        } else {
            processAjax("DELETE", url, parameter, name);
            document.location.href = "/dashboard/channels/all";
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
                document.location.href = "/dashboard/channels/all";
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
    document.location.href = "/dashboard/channels/all";
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

                default: console.log(response);//errorMessage( response.message );
            }
        }
    });
}
