$(document).ready(function() {
    $("a#comment_action_caret").on("click", function(event) {

        event.preventDefault();

        $(".textarea-wrapper #comment_actions").not($(this).next()).hide("slow");

        $(this).next().toggle("slow");
    });

    $("#comment_actions a.comment-action-delete").on("click", function(event) {
        event.preventDefault();

        var token = $(this).attr('data-token');
        var comment = $(this).attr('data-commentId');

        swal({
            title: "Are you sure?",
            text: "You will not be able to recover a deleted comment",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function() {
            //delete comment
            var deleteComment = $.ajax({
                method: "DELETE",
                url: "/comment/" + comment,
                data: {
                    _token: token
                }
            });

            deleteComment.done(function(response) {
                swal({
                    title: "Deleted!",
                    text: "Comment successfully deleted",
                    type: "success"
                }, function() {
                    location.reload();
                });

            });
            deleteComment.fail(function(response) {
                swal("Error Deleting", "Something happened while deleting your comment. please try again", "error");
            });
        });
    });

    $("#comment_actions a.comment-action-edit").on("click", function(event) {
        event.preventDefault();

        var parent = $(this).parent().parent().parent();

        var commentWrapper = parent.find("span:first");
        var comment = commentWrapper.text().trim();

        var updateActions = parent.find(".update-actions").hide("slow", function() {

            var updateComment = '<div class="file-field input-field">';
            updateComment += '<div class="file-path-wrapper input-field col s10 m10">';
            updateComment += '<input name="comment" id="comment-field" class="validate" type="text" style="margin-left:20px;" required="true" value="' + comment + '"/>';
            updateComment += '</div>';
            updateComment += '<button type="submit" id="update-comment" class="btn right comment-submit"><i class="fa fa-paper-plane-o"></i></button>';
            updateComment += '</div>';


            commentWrapper.replaceWith(updateComment);
        });
    });

    $(".textarea-wrapper").on("click", "#update-comment", function() {
        var this_ = $(this);

        var comment = this_.prev().find("input").val().trim();
        var commentId = this_.parent().parent().attr("data-comment-id");
        var token = this_.parent().parent().attr("data-token");

        var updateComment = $.ajax({
            method: "PUT",
            url: "/comment/" + commentId + "/edit",
            data: {
                _token: token,
                comment: comment
            }
        });

        updateComment.done(function(response) {
            swal({
                title: "Updated!",
                text: "Comment successfully updated",
                type: "success"
            }, function() {
                location.reload();
            });

        });
        updateComment.fail(function(response) {
            swal("Error Deleting", "Something happened while updating your comment. please try again", "error");
        });

    });
});
