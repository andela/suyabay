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
        // confirmDelete(data.url, data.parameter, data.parameter.channel_id, data.parameter.channel_name );
        processAjax("DELETE", data.url, data.parameter, data.parameter.channel_name );

        return false;
    });

    $("#swap_episode_delete_channel", this).on("click", function () {
        var id      = $(this).data("id");
        var url     = "/dashboard/channel/"+id;
        var token   = $(this).data("token");
        var name    = $(this).data("name");
        var episodes = $(this).data("episoes");
        var data    =  {
            url : url,
            parameter: {
                _token       : token,
                channel_id   : id,
                channel_name : name,
                episodes : episodes
            }
        }
        confirmDelete(data.url, data.parameter, data.parameter.channel_id, data.parameter.channel_name );

        return false;
    });

    /**
     * onSubmit swap channels
     */
    $("#swap_episodes").submit( function () {
        var url     = "/dashboard/channel/swap/"+id;
        var data    =
            {
                parameter  :
                {
                    _token        : $("#token").val(),
                    channel_id              : $("#channel_id").val(),
                    new_channel_id          : $("#new_channel_id").val()
                }
            }

        processAjax("POST", url, data.parameter, data.parameter.new_channel_id);

        return false;
    });

    /**
     * onSubmit event to handle Channel update
     */
    $("#channel_update").submit( function (event) {

        event.preventDefault();

        var channelName = $("#channel_name").val().trim();
        var channelDescription = $("#channel_description").val().trim();

        if( channelName.length != 0 && channelDescription.length ) {

            var data =
            {
                url        : "/dashboard/channel/edit",
                parameter  :
                {
                    _token                : $("#token").val(),
                    channel_id            : $("#channel_id").val(),
                    channel_name          : channelName,
                    channel_description   : channelDescription
                }
            }
            processAjax("PUT", data.url, data.parameter, data.parameter.channel_name );
        } else{
            swal({
                title: "Error!",
                text: "Please provide both a channel name and description",
                type: "error",
                showCancelButton: false,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            });
        }

        return false;
    });

    /**
     * onSubmit event to handle Channel update
     */
    $("#episode_update").submit( function () {

        var data =
        {
            url        : "/dashboard/episode/edit",
            parameter  :
            {
                _token                : $("#token").val(),
                episode_id            : $("#episode_id").val(),
                episode               : $("#episode").val(),
                channel_id            : $("#channel_id").val(),
                description           : $("#description").val()
            }
        }

        processEpisodeUpdate("PUT", data.url, data.parameter, data.parameter.episode );

        // confirmUpdate(data.url, data.parameter, data.parameter.episode_name, data.parameter.channel_id);


        return false;
    });

    /**
     * onSubmit event to handle User Edit
     */
    $("#create_user").submit( function () {
        var url       = "/dashboard/user/create";
        var token     = $("#_token").val();
        var username  = $("#username").val();
        var userRole = $("#user_role").val();
        var data =
            {
                url        : url,
                parameter  :
                {
                    _token      : token,
                    username    : username,
                    user_role   : userRole
                }
            }
        processAjax("POST", data.url, data.parameter, data.parameter.username );

        return false;
    });

    /**
     * onSubmit event to handle User Edit
     */
    $("#edit_user").submit( function () {
        var data =
            {
                url        : "/dashboard/user/edit",
                parameter  :
                {
                    _token      : $("#_token").val(),
                    user_id     :  $("#user_id").val(),
                    username    : $("#username").val(),
                    user_role   : $("#user_role").val()
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
        text: "This Channel has Episodes, deleting it implies deleting all the Episodes under it. Are you sure you want to do this?",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#009688",
        confirmButtonText: "Yes, please!",
        cancelButtonText: "Cancel",
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
            document.location.href = "/dashboard/channels/all";
        }
    });
}

function confirmUpdate (url, parameter, name, id)
{
    swal({   title: "Success!",   text: id,   timer: 1500,   showConfirmButton: false });
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

                default: errorMessage( response.message );
            }
        }
    });
}


function processEpisodeUpdate (action, url, parameter, name)
{
    $.ajax({
        url: url,
        type: action,
        data: parameter,
        success: function(response) {
            switch( response.status_code )
            {
                case 200:
                    return successMessage( response.message );
                    break;

                default: errorMessage( response.message );
            }
        }
    });
}

function successMessage (message)
{
    swal("Good job!", "Episode succesfuly updated!", "success");
    document.location.href = "/dashboard/episodes";
}
