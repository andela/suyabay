$(document).ready(function(){

	$('.comment-submit').on('click', function(){
		var divId = $(this).attr('title');
		var comment = $("#comment-field"+divId).val();
		var avatar = $(this).attr('data-avatar');
		$('.load_comment'+divId).last().append('<div id="show_comment" class="collection-item avatar show_comment'+divId +'"><div class="row"><div class="col s2"><img src="'+ avatar +'" alt="" class="circle"></div><div class="col s10"><div class="textarea-wrapper" placeholder="">'+
											                comment
											            +'</div></div></div></div>');
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
                    return true
                    break;

                default: return false;
            }
        }
    });
}