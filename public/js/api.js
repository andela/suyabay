
	var  clipboard = new Clipboard(".copy");

	clipboard.on("success", function() {
    	swal("Token copied successfully");
	});


	$('#delete-api').click(function() {
		var id      = $(this).data("id");
        var url     = "/developer/myapp/"+id+"/delete";
        var data    =  {
            parameter: {
                _token       : $(this).data("token")
            }
        }
        confirmApiDelete(url);

        return false;
    });

/**
 *process the ajax call
 *
 * @param  url
 * @param  parameter
 */
function processAjaxApiCall (url, parameter)
{
    $.ajax({
        url: url,
        type: 'GET',
        data: parameter,
        success: function(response) {
            if (response == 200) {
            	apiSuccessMessage();
            } else {
            	swal({
            		title: "Cancelled", 
            		text:   "Your app is retained",
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
function confirmApiDelete (url)
{
    swal({   
    	title: "Are you sure?",   
    	text: "You will not be able to recover this app!",   
    	type: "warning",   
    	showCancelButton: true,   
    	confirmButtonColor: "#26a69a",   
    	confirmButtonText: "Yes, delete it!",   
    	cancelButtonText: "No, retain my app!",   
    	closeOnConfirm: false,   
    	closeOnCancel: false 
    }, 
    function(isConfirm)
    {   
    	if (isConfirm) {     
    		processAjaxApiCall(url);   
    	} else {     
    		swal("Cancelled", "Your app will be retained :)", "error");   
    	} 
    });
}

/**
 *Sweetalert Delete message
 *
 */
function apiSuccessMessage ()
{
    swal({
            title: "Done!",
            text: "App deleted successfully",
            type: "success",
            showCancelButton: false,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            },
            function (){
                document.location.href = "/developer/myapp/";
            }
        );
}