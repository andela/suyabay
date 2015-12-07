$(document).ready(function(){

    /**
     * onClick event to handle Channel delete
     */
    $(".delete_channel", this).on('click', function () {
        var id    = $(this).data("id");
        var url   = "/dashboard/channel/delete/"+id;
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
        processAjax(data.url, data.parameter, data.parameter.channel_name );
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
        processAjax(data.url, data.parameter, data.parameter.channel_name );
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
        processAjax(data.url, data.parameter, data.parameter.user_name );
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
        if( isConfirm )
        {
            processAjax(url, parameter, name);
        }
        else
        {
            cancelDeleteMessage( name );
        }
    });
}

/**
 * successDeleteMessage modal message
 *
 * @param  name
 */
function successDeleteMessage (name)
{
    swal({
            title: "Deleted!",
            text: "Channel " + name + " has been deleted successfully",
            type: "success",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            },
            function (){
                document.location.href = "/dashboard/channels";
            }
        );
}

/**
 * successUpdateMessage modal message
 */
function successUpdateMessage ()
{
    swal({
            title: "Done!",
            text: "Your update is successful",
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
 * successCreateMessage modal message
 */
function successCreateMessage ()
{
    swal({
            title: "Done!",
            text: "New Channel has been added successfully",
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
function successEditUser ()
{
    swal({
            title: "Done!",
            text: "User has been successfully updated",
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
 * errorMessage modal message
 */
function errorMessage ()
{
    swal("Error", "Error processing your request, Please try again!!!", "error");
}

/**
 * processAjax Proccess the ajax call
 *
 * @param  url
 * @param  parameter
 * @param  name
 */
function processAjax (url, parameter, name)
{
    $.post(url, parameter, function( data ){
        if( data == 300){
            return successDeleteMessage( name );
        }
        else if(data == 200){
            return successUpdateMessage(name);
        }
        else if(data == 100){
            return successCreateMessage(name);
        }
        else if (data == 600){
            return successEditUser();
        }
        else
        {
            errorMessage();
        }
    });
}
