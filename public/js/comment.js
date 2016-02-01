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

							//Increment comment upon successful submission
							$("#comment-count").html(" "+comment_count);

							//Append comment to the last comment in the element
							$(".load_comment").last().append('<div id="show_comment" class="collection-item avatar show_comment' +'"><div class="row"><div class="col s2"><img src="'+ avatar +'" alt="" class="circle"></div><div class="col s10"><div class="textarea-wrapper" placeholder="">'+comment+'</div></div></div></div>');

							//Reset form data
							document.getElementById("submit_comment").reset();
						break;

						default: return false;
					}
				}
			});
		}

		return false;
	});

});
