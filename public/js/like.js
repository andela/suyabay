
$(document).ready(function() {

	$('.like-btn').click(function () {

		var
		status 		  = $(this).attr("like-status"),
		like_count	  = $(this).html();
		favoriteCount = $("#favorite").html();

		if (status === "like")
		{
			$(this).removeClass("like");
			$(this).addClass("dislike");
			$(this).attr("like-status", "dislike");

			likeEpisode()

			like_count = Number(like_count) + 1;
			favoriteCount = Number(favoriteCount) + 1

			$(this).text( " " + like_count);
			$("#favorite").html(favoriteCount);
		}

		if (status === "dislike")
		{
			$(this).removeClass("dislike");
			$(this).addClass("like");
			$(this).attr("like-status", "like");

			dislikeEpisode()

			like_count = Number(like_count) - 1;
			favoriteCount = Number(favoriteCount) - 1

			$(this).text(" " + like_count);
			$("#favorite").html(favoriteCount);
		}

		if (status === "must_login") 
		{
			window.location = '/login';
		}

	})

	/*
	# Like Episode Function
	*/
	function likeEpisode()
	{
		var
		url 			= "/episode/like",
		token 			= document.getElementById("token").value,
		method 			= "POST";

	  	var data =
	    {
	        url         	: url,
	        method 			: method,
	        parameter   	:
	        {
	          _token		: token,
	          user_id		: document.getElementById('user_id').value,
	          episode_id	: document.getElementById('episode_id').value
	        }
	    }

		ajaxCall(data)
	}

	/*
	# Dislike Episode Function
	*/
	function dislikeEpisode()
	{
		var
		url 			= "/episode/unlike",
		token 			= document.getElementById("token").value,
		method 			= "post";

	  	var data =
	    {
	        url         	: url,
	        method 			: method,
	        parameter   	:
	        {
	          _token		: token,
	          user_id		: document.getElementById("user_id").value,
	          episode_id	: document.getElementById("episode_id").value
	        }
	    }

		ajaxCall(data)
	}

	/*
	# Ajax
	*/
	function ajaxCall(data)
	{
		$.ajax({
			url		: data.url,
			type	: data.method,
			data	: data.parameter,
			success: function (response)
			{
			},
			error: function()
			{
				alert("Are you sure you doing this the right way?");
			},
		});
	}
})