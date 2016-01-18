$(document).ready(function(){

	/**
     * onSubmit event to handle Channel creation
     */
    $("#submit_comment").submit( function () {
        var url        = "/comment";
        var token      = $("#_token").val();
        var user_id    = $("#user_id").val();
        var episode_id = $("#episode_id").val();
        var comment    = $("#comment-field").val();
        var data =
            {
                url        : url,
                parameter  :
                {
                    _token     : token,
                    user_id    : user_id,
                    episode_id : episode_id,
                    comment    : comment
                }
            }
        processCommentAjax("POST", data.url, data.parameter);

        return false;
    });

});

function processCommentAjax (action, url, parameter)
{

    $.ajax({
        url: url,
        type: action,
        data: parameter,
        success: function(response) {
            switch( response.status_code )
            {
                case 200:
                    $('.collection-item .avatar').apend('<li class="collection-item avatar">'+
	                            +'<div class="row">'+
	                                +'<div class="col s2">'+
	                                    +'<img src="{{ $comment->user->getAvatar() }}" alt="" class="circle">'+
	                                +'</div>'+
	                                +'<div class="col s10">'+
	                                    +'<div class="textarea-wrapper" placeholder="">'+
	                                        parameter.comment
	                                    +'</div>'+
	                                +'</div>'+
	                            +'</div>'+
	                        +'</li>');
                    break;

                default: alert(0);
            }
        }
    });
}