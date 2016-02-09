$(document).ready(function(){

	$(".comment-submit").on("click", function(){
		
		var comment       = $("#comment-field").val();
		var avatar        = $(this).data("avatar");
		var comment_count = parseInt($(this).data("comment-count")) + 1;
		var token         = $(this).data("token");

		var url        = "/comment";
		var user_id    = $("#user_id").val();
		var episode_id = $("#episode_id").val();

		var data =
			{
				parameter  :
					{
						_token     : token,
						user_id    : user_id,
						episode_id : episode_id,
						comment    : comment
					}
			}
		if (comment.length > 0) {
			//Process AJAX request
			$.ajax({
				url    : url,
				type   : "POST",
				data   : data.parameter,

				success: function(response) {
					switch (response.status_code)
					{
						case 200:

							location.reload();
						break;

						default: return false;
					}
				}
			});
		}

		return false;
	});

});
