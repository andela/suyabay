$(document).ready(function(){

	$(".comment-submit").on("click", function(){
		var divId         = $(this).data("id");
		var comment       = $("#comment-field"+divId).val();
		var avatar        = $(this).data("avatar");
		var comment_count = parseInt($(this).data("comment-count")) + 1;
		var token         = $(this).data("token");

        var url        = "/comment";
        var user_id    = $("#user_id"+divId).val();
        var episode_id = $("#episode_id"+divId).val();

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
            
        //Process AJAX request
        $.ajax({
	        url: url,
	        type: "POST",
	        data: data.parameter,
	        success: function(response) {
	            switch (response.status_code)
	            {
	                case 200:

							//Increment comment upon successful submission
							$("#comment-count"+divId).html(" "+comment_count);

							//Append comment to the last comment in the element
							$(".load_comment"+divId).last().append('<div id="show_comment" class="collection-item avatar show_comment'+divId +'"><div class="row"><div class="col s2"><img src="'+ avatar +'" alt="" class="circle"></div><div class="col s10"><div class="textarea-wrapper" placeholder="">'+
											                comment
											            +'</div></div></div></div>');

							//Reset form data
							document.getElementById("submit_comment"+divId).reset();
	                    break;

	                default: return false;
	            }
	        }
	    });
        

		return false;
	});

});
