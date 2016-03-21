
$(document).ready(function() {

	$(".like-btn").click(function () {

		var status 		  = $(this).attr("like-status");
		var like_count	  = $(this).html();
		var favoriteCount = $("#favorite").html();

		if (status === "like")
		{
			$(this).removeClass("like");
			$(this).addClass("dislike");
			$(this).attr("like-status", "dislike");

			likeEpisode()

			like_count = Number(like_count) + 1;
			favoriteCount = Number(favoriteCount) + 1;

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
			favoriteCount = Number(favoriteCount) - 1;

			$(this).text(" " + like_count);
			$("#favorite").html(favoriteCount);

			//check if the string favorites is present in the current url
			if (/favorites/.test(window.location.pathname)) {
				location.reload();
			}
		}

		if (status === "must_login")
		{
			window.location = "/login";
		}

	})

	/*
	# Like Episode Function
	*/
	function likeEpisode()
	{
		var url 			= "/episode/like";
		var token 			= document.getElementById("token").value;
		var method 			= "POST";

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
	# Dislike Episode Function
	*/
	function dislikeEpisode()
	{
		var url 			= "/episode/unlike";
		var token 			= document.getElementById("token").value;
		var method 			= "post";

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