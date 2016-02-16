$(document).ready(function() {

    $('.load_comment').on('click', 'a#comment_action_caret', function(event) {

        event.preventDefault();

        $('.textarea-wrapper #comment_actions')
            .not($(this)
                .next())
            .hide('slow');

        $(this).next().toggle('slow');
    });

    $('.load_comment').on('click',
        '#comment_actions a.comment-action-delete',
        function(event) {

            event.preventDefault();

            var this_ = $(this);
            var token = $('.load_comment').attr('data-token');
            var comment = this_.attr('data-commentId');

            swal({
                title: 'Are you sure?',
                text: 'You will not be able to recover a deleted comment',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, delete it!',
                closeOnConfirm: true
            }, function() {

                //delete comment
                var deleteComment = $.ajax({
                    method: 'DELETE',
                    url: '/comment/' + comment,
                    data: {
                        _token: token
                    }
                });

                deleteComment.done(function() {
                    this_.parent().parent().parent().parent().parent().parent().remove();

                });

                deleteComment.fail(function() {

                    swal('Error Deleting',
                        'Something happened while deleting your comment. please try again',
                        'error'
                    );
                });
            });
        });

    $('.load_comment').on('click', '#comment_actions a.comment-action-edit', function(event) {

        event.preventDefault();

        var parent = $(this)
            .parent()
            .parent()
            .parent();

        var commentWrapper = parent.find('span:first');
        var comment = commentWrapper.text().trim();

        parent.find('.update-actions').hide('slow', function() {

            var updateComment = '<div class="file-field input-field">';
            updateComment += '<div class="file-path-wrapper input-field col s10 m10">';
            updateComment += '<input name="comment" id="comment-field" class="validate" type="text"';
            updateComment += 'style="margin-left:20px;" required="true" value="' + comment + '"/>';
            updateComment += '</div>';
            updateComment += '</div>';


            commentWrapper.replaceWith(updateComment);
        });
    });

    $('.load_comment').on('keypress', '#comment-field', function(event) {

        if (event.which == 13) {

            var this_ = $(this);

            var comment = this_.val().trim();
            var commentId = this_
                .parent()
                .parent()
                .parent()
                .attr('data-comment-id');

            var token = $('.load_comment').attr('data-token');

            if (comment.length === 0 || commentId.length === 0 || token.length === 0) {
                swal('Error Updating',
                    'Something is missing in your comment. Please try again',
                    'error'
                );
            } else {

                var updateComment = $.ajax({
                    method: 'PUT',
                    url: '/comment/' + commentId + '/edit',
                    data: {
                        _token: token,
                        comment: comment
                    }
                });

                updateComment.done(function() {

                    swal({
                        title: 'Updated!',
                        text: 'Comment successfully updated',
                        type: 'success'
                    }, function() {
                        location.reload();
                    });

                });

                updateComment.fail(function() {

                    swal('Error Updating',
                        'Something happened while updating your comment. Please try again',
                        'error'
                    );
                });
            }
        }
    });
});
