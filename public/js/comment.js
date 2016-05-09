$(document).ready(function() {

    $(".view_more_comments").on("click",function() {
        var avatar = $(this).data('avatar');
        var numOfComments = $(".load_comment").find("div#show_comment");
        var episodeId  = $("#episode_id").val();

        try {

            $.ajax({
                url:'/comment',
                type:'GET',
                data:{
                     offset: numOfComments.size(),
                     episode_id: episodeId
            },
            success: function(data) {
                for (i = 0 ; i < data.comments.length; i++) {
                    var comments = data.comments[i];
                    $('#comment-count').html(' ' + numOfComments.size());

                     var newComment = '<div id="show_comment" class="collection-item avatar show_comment">';
                     newComment    += '<div class="row">';
                     newComment    += '<div class="col s2">';
                     newComment    += '<img src="' + avatar + '" alt="" class="circle">';
                     newComment    += '</div>';
                     newComment    += '<div class="col s10">';
                     newComment    += '<div class="textarea-wrapper" ';
                     newComment    += 'data-comment-id="' + comments.id + '">';
                     newComment    += '<span>' + comments.comments + '</span>';
                     newComment    += '<div class="update-actions pull-right">';
                     newComment    += '<a href="#" id="comment_action_caret" class="fa fa-bars no-style-link"></a>';
                     newComment    += '<div id="comment_actions" style="display:none">';
                     newComment    += '<a href="#" class="fa fa-pencil comment-action-edit no-style-link" ';
                     newComment    += 'data-commentId="' + comments.id + '"></a>';
                     newComment    += '<a href="#" class="fa fa-trash comment-action-delete no-style-link" ';
                     newComment    += 'data-commentId="' + comments.id + '"></a>';
                     newComment    += '</div>';
                     newComment    += '</div>';
                     newComment    += '</div></div></div></div>';

                     $('.load_comment').last().append(newComment);
                     $('#new-comment-field').val('');
                }
            }
        });
        } catch (e) {

            console.log(e);
        }

        return false;
    });


    $('.comment-submit').on('click', function() {

        var comment = $('#new-comment-field').val();
        var avatar = $(this).data('avatar');
        var commentCount = parseInt($(this).data('comment-count')) + 1;
        var token = $(this).data('token');

        var url = '/comment';
        var user_id = $('#user_id').val();
        var episodeId = $('#episode_id').val();

        var data = {
            parameter: {
                _token: token,
                episode_id: episodeId,
                comment: comment
            }
        }
        if (comment.length > 0) {
            //Process AJAX request
            $.ajax({
                url: url,
                type: 'POST',
                data: data.parameter,

                success: function(response) {

                    switch (response.status_code) {
                        case 200:

                            var newComment = '<div id="show_comment" class="collection-item avatar show_comment">';
                            newComment += '<div class="row">';
                            newComment += '<div class="col s2">';
                            newComment += '<img src="' + avatar + '" alt="" class="circle">';
                            newComment += '</div>';
                            newComment += '<div class="col s10">';
                            newComment += '<div class="textarea-wrapper" ';
                            newComment += 'data-comment-id="' + response.commentId + '">';
                            newComment += '<span>' + comment + '</span>';
                            newComment += '<div class="update-actions pull-right">';
                            newComment += '<a href="#" id="comment_action_caret" class="fa fa-bars no-style-link"></a>';
                            newComment += '<div id="comment_actions" style="display:none">';
                            newComment += '<a href="#" class="fa fa-pencil comment-action-edit no-style-link" ';
                            newComment += 'data-commentId="' + response.commentId + '"></a>';
                            newComment += '<a href="#" class="fa fa-trash comment-action-delete no-style-link" ';
                            newComment += 'data-commentId="' + response.commentId + '"></a>';
                            newComment += '</div>';
                            newComment += '</div>';
                            newComment += '</div></div></div></div>';

                            $('.load_comment').last().append(newComment);
                            //Increase the count by 1 after submitting a comment
                            var count = $('#comment-count').html();
                            count = Number(count) + 1;

                            //Set this new value in the html
                            $('#comment-count').html(count);

                            //empty the comment field
                            $('#new-comment-field').val('');

                            break;

                        default:
                            return false;
                    }
                }
            });
        }

        return false;
    });

});
