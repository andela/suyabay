$(document).ready(function() {


    $(".view_more_comments").on("click",function() {

        var avatar = $(this).data('avatar');

        try {

            var numOfComments = $(".load_comment").find("div#show_comment");

            alert(numOfComments.size());

            $.ajax({

            url:'/comment',
            type:'GET',
            data:{'offset': 10},

            success: function(data) {

                for(i = 0 ; i < data.comments.length; i++)
                {
                    var comments = data.comments[i];

                    console.log("data", data.comments[i]);

                    $('#comment-count').html(' ' + numOfComments);

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
        var comment_count = parseInt($(this).data('comment-count')) + 1;
        var token = $(this).data('token');

        var url = '/comment';
        var user_id = $('#user_id').val();
        var episode_id = $('#episode_id').val();

        var data = {
            parameter: {
                _token: token,
                episode_id: episode_id,
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

                            //Increment comment upon successful submission
                            $('#comment-count').html(' ' + comment_count);

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
