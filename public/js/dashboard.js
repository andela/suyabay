$(document).ready(function() {

    $(".btn").click(function() {
        var id   = $(this).data("id");
        var url  = "/dashboard/episode/"+id+"/delete";

        confirmEpisodeDelete(url);

        return false;
    });

    /**
     *process the ajax call
     *
     * @param  url
     * @param  parameter
     */
    function processDeleteAjaxCall(url, parameter)
    {
        $.ajax({
            url: url,
            type: "GET",
            data: parameter,
            success: function(response) {
                if (response.status_code == 200) {
                    deleteSuccessMessage();
                } else {
                    swal({
                        title: "Cancelled",
                        text:   "episode is retained",
                        confirmButtonColor: "#26a69a",
                        type: "error"
                    });
                }
            }
        });
    }

    /**
     *confirmDelete modal message
     *
     * @param  url
     */
    function confirmEpisodeDelete(url)
    {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this episode!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#26a69a",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, retain episode!",
            closeOnConfirm: false,
            closeOnCancel: false
        },

        function(isConfirm)
        {
            if (isConfirm) {
                processDeleteAjaxCall(url);
            } else {
                swal("Cancelled", "episode will be retained", "error");
            }
        });
    }

    /**
     *Sweetalert Delete message
     *
     */
    function deleteSuccessMessage()
    {
        swal({
            title: "Done!",
            text: "Episode deleted successfully",
            type: "success",
            showCancelButton: false,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },

        function (){
            document.location.href = "/dashboard/episodes";
        });
    }

    var item;

    $('.episode_action').on('change', function() {

        /*
		# Get <select/> element that was clicked on
    	*/
        var actionType = $(this).val(),

       /*
		# Get <select/> element data-action
    	*/
         action = $(this).find('option:selected').data('action');

        /*
		# Add class to parent element of the <select/> element
    	*/
        $(this).parent().closest('tr').prop('class', 'selected');


        if (actionType === 'view') {
            window.location = action;
        }

        if (actionType === 'delete') {
            deleteEpisode(action)
        };

        if (actionType === 'activate') {

            item = $(this).parent().closest('tr');
            activateEpisode(action)
        };
    });


    /*
    # Delete Episode Function
    */
    function deleteEpisode(episodeId) {
        var
            url = '/dashboard/episode/delete',
            token = document.getElementById('token').value,
            method = 'DELETE',
            episode_id = episodeId,
            functionName = arguments.callee.name;

        var data = {
            url: url,
            method: method,
            parameter: {
                _token: token,
                episode_id: episodeId
            }
        }

        swal({
                title: 'Delete Episode',
                text: 'You will not be able to recover this episode!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                closeOnCancelnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    ajaxCall(data, functionName)
                } else {
                    swal('Cancelled', 'Your episode is safe :)', 'error');
                }
            });
    }

    /*
    # Delete Episode Function
    */
    function activateEpisode(episodeId) {

        var functionName = arguments.callee.name;
        var data = {
            url: '/dashboard/episode/activate',
            method: 'PATCH',
            parameter: {
                _token: document.getElementById('token').value,
                episode_id: episodeId
            }
        }

        swal({
                title: 'Activate Episode',
                text: 'This Episode will be visible on your channel',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'success',
                confirmButtonText: 'Activate',
                cancelButtonText: 'Cancel!',
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    ajaxCall(data, functionName)
                } else {
                    swal('Cancelled', 'Your episode is safe :)', 'error');
                }
            });
    }



    /*
    # Ajax
    */
    function ajaxCall(data, functionName) {
        $.ajax({
            url: data.url,
            type: data.method,
            data: data.parameter,
            success: function(response) {
                ajaxLogic(response, functionName)
            },
            error: function() {
                alert('Are you sure you doing this the right way?');
            },
        });
    }


    function ajaxLogic(response, functionName) {
        /*
        # Check if Response.status = 401
        */
        if (response.status === 401) {
            switch (functionName) {
                case 'deleteEpisode':
                    deleteEpisodeErrorAlert();
                    break;
                case 'activateEpisode':
                    activateEpisodeErrorAlert();
                    break;
            }
        }

        /*
        # Check if Response.status = 200
        */
        if (response.status === 200) {
            switch (functionName) {
                case 'deleteEpisode':
                    deleteEpisodeSuccessAlert();
                    break;
                case 'activateEpisode':
                    activateEpisodeSuccessAlert();
                    break;
            }
        }
    }

    /*
    # deleteEpisodeErrorAlert Message
    */
    function deleteEpisodeErrorAlert() {
        swal('Hmmmm', 'This episode does not exist ', 'error');
    }

    /*
    # deleteEpisodeSuccessAlert Message
    */
    function deleteEpisodeSuccessAlert() {
        swal('Deleted!', 'Your episode has been deleted.', 'success');
        var deleted = $('.selected');
        deleted.hide();
    }

    /*
    # activateEpisodeErrorAlert() Message
    */
    function activateEpisodeErrorAlert() {
        swal('Hmmmm', 'This episode does not exist ', 'error');
    }

    function activateEpisodeSuccessAlert() {
        swal('Activated', 'Your episode has been Activated.', 'success');

        var deleted = $('.selected');
        var newItem = $('#active_section');

        newItem.append(item[0]);

        deleted.show();
    }

});
