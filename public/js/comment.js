$(document).ready(function(){

	$('.comment-submit').on('click', function(){
		var divId = $(this).attr('title');
		var comment = $("#comment-field"+divId).val();
		var avatar = $(this).attr('data-avatar');

        var url        = "/comment";
        var token      = $("#_token"+divId).val();
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

        $.ajax({
	        url: url,
	        type: "POST",
	        data: data.parameter,
	        success: function(response) {
	            switch( response.status_code )
	            {
	                case 200:
							$('.load_comment'+divId).last().append('<div id="show_comment" class="collection-item avatar show_comment'+divId +'"><div class="row"><div class="col s2"><img src="'+ avatar +'" alt="" class="circle"></div><div class="col s10"><div class="textarea-wrapper" placeholder="">'+
											                comment
											            +'</div></div></div></div>');
	                    break;

	                default: return false;
	            }
	        }
	    });
        

		return false;
	});

});
