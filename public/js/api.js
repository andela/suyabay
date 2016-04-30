var  clipboard = new Clipboard(".copy");

clipboard.on("success", function() {
    swal("Token copied successfully");
});

$("#delete-api").click(function() {
    var id   = $(this).data("id");
    var url  = "/developer/myapp/"+id+"/delete";

    confirmApiDelete(url);

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
function confirmApiDelete(url)
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
    	    processDeleteAjaxCall(url);
        } else {
    	    swal("Cancelled", "Your app will be retained", "error");   
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
        text: "App deleted successfully",
        type: "success",
        showCancelButton: false,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    },

    function (){
        document.location.href = "/developer/myapp/";
    });
}



/**
 * onSubmit event to handle app update
 */
$("#app-update").submit( function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    var id           = $("#id").val();
    var name         = $("#name").val().trim();
    var homepage_url = $("#homepage_url").val().trim();
    var description  = $("#description").val().trim();

    if( name.length != 0 && description.length  ) {

        var data =
        {
            url        : "/developer/myapp/edit/",
            parameter  :
            {
                id            : id,
                name          : name,
                homepage_url  : homepage_url,
                description   : description
            }
        }
       
        processUpdateAjaxCall("PUT", data.url, data.parameter);
    } else{
        swal({
            title: "Error!",
            text: "Please provide both name and description",
            type: "error",
            showCancelButton: false,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        });
    }

    return false;
});


/**
 * processUpdateAjaxCall Proccess the ajax call
 *
 * @param  url
 * @param  parameter
 * @param  name
 */
function processUpdateAjaxCall (action, url, parameter)
{
    $.ajax({
        url: url,
        type: action,
        data: parameter,
        success: function(response) {
            console.log(response)
            if ( response.status_code === 200) {
                updateSuccessMessage();     
            } else if (response.status_code === 404) {
                 swal("Cancelled", "Your app was unable to update successfully", "error"); 
            } else {
                 swal("Cancelled", "App name already exist", "error"); 
            }
        }, error: function (error) {
            swal({
                title: "Done!",
                text: "Please input the right url format",
                type: "error",
                showCancelButton: false,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            })
        }
    });
}

/**
 *Sweetalert update message
 *
 */
function updateSuccessMessage()
{
    swal({
        title: "Done!",
        text: "App updated successfully",
        type: "success",
        showCancelButton: false,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    },

    function (){
        document.location.href = "/developer/myapp/";
    });
}