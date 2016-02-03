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
        swal("To edit comment");
    });
});
