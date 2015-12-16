$( document ).ready(function() {
    
	$('.episode_action').click(function(){
    	
    	var 
    	/*
		# Get <select/> element that was clicked on
    	*/
    	action_type = $(this).val(),
    	
    	/*
		# Get <select/> element data-action
    	*/
    	action = $(this).find('option:selected').data('action');
		
		/*
		# Add class to parent element of the <select/> element
    	*/
    	$(this).parent().closest('tr').prop("class", "selected");
    	

    	if ( action_type === "view" ) 
    	{
    		window.location = action;
    	}

    	if ( action_type === "delete" ) 
    	{
    		deleteEpisode(action)
    	};

    	if ( action_type === "activate" ) 
    	{
    		deleteEpisode(action)
    	};
	});


	/*
	# Delete Episode Function
	*/
	function deleteEpisode (episode_id) 
	{	
		var 
		url 		= "/dashboard/episode/delete",
		token 		= document.getElementById('token').value,
		episode_id 	= 4,
		functionName =  arguments.callee.name;

	  	var data =
	    {
	        url         : url,
	        parameter   :
	        {
	          _token 	  : token,
	          episode_id  : episode_id
	        }
	    }

		swal(
		{
			title: "Delete Episode",
			text: "You will not be able to recover this episode after this action!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, delete it!",
			cancelButtonText: "No, cancel!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm)
		{
		  if (isConfirm) 
		  {
		    ajaxCall( data, functionName)
		  } 
		  else 
		  {
			swal("Cancelled", "Your episode is safe :)", "error");
		  }
		});
	}

	/*
	# Ajax
	*/
	function ajaxCall ( data, functionName)
	{
		$.ajax({
			url: data.url,
			type: 'DELETE',
			data: data.parameter,
			success: function (response) 
			{ 
				ajaxLogic ( response, functionName )
			},
			error: function () 
			{ 
				alert('bad');
			},
		});
	}


	function ajaxLogic ( response, functionName ) 
	{
		/*
		# Check if Response.status = 401
		*/
		if ( response.status === 401 ) 
		{
			switch (functionName)
	        {
	          case "deleteEpisode" : deleteEpisodeErrorAlert(); break
	        }
		}

		/*
		# Check if Response.status = 200
		*/
		if ( response.status === 200 ) 
		{
			switch (functionName)
	        {
	          case "deleteEpisode" : deleteEpisodeSuccessAlert(); break
	        }
		}
	}










	/*
	# deleteEpisodeErrorAlert Message
	*/
	function deleteEpisodeErrorAlert () 
	{
		swal("Hmmmm", "This episode does not exist ", "error");
	}

	/*
	# deleteEpisodeSuccessAlert Message
	*/
	function deleteEpisodeSuccessAlert () 
	{		
		swal("Deleted!", "Your episode has been deleted.", "success");
		var deleted =  $('.selected');
		deleted.hide();
	}



});