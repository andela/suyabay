
$(document).ready(function() {

    $('.like-btn').click(function () {

        var this_ = $(this);

        var status        = $(this).attr('like-status');
        var likeCount    = $(this).html();
        var favoriteCount = $('#favorite').html();

        if (status === 'like')
        {
            $(this).removeClass('like');
            $(this).addClass('dislike');
            $(this).attr('like-status', 'dislike');

            likeEpisode();

            likeCount = Number(likeCount) + 1;
            favoriteCount = Number(favoriteCount) + 1;

            $(this).text( ' ' + likeCount);
            $('#favorite').html(favoriteCount);
        }

        if (status === 'dislike')
        {
            $(this).removeClass('dislike');
            $(this).addClass('like');
            $(this).attr('like-status', 'like');

            dislikeEpisode(this_);

            likeCount = Number(likeCount) - 1;
            favoriteCount = Number(favoriteCount) - 1;

            $(this).text(' ' + likeCount);
            $('#favorite').html(favoriteCount);

            //check if the string favorites is present in the current url
            if (/favorites/.test(window.location.pathname)) {
                location.reload();
            }
        }

        if (status === 'must_login')
        {
            window.location = '/login';
        }

    });

    /*
    # Like Episode Function
    */
    function likeEpisode()
    {
        var data =
        {
            url             : '/episode/like',
            method          : 'POST',
            parameter       : {
              _token        : document.getElementById('token').value,
              user_id       : document.getElementById('user_id').value,
              episode_id    : document.getElementById('episode_id').value
            }
        };

        ajaxCall(data);
    }

    /*
    # Dislike Episode Function
    */
    function dislikeEpisode(this_)
    {
        var data =
        {
            url             : '/episode/unlike',
            method          : 'POST',
            parameter       : {
              _token        : document.getElementById('token').value,
              user_id       : document.getElementById('user_id').value,
              episode_id    : this_.attr('data-episode-id')
            }
        };

        ajaxCall(data);
    }

    /*
    # Ajax
    */
    function ajaxCall(data)
    {
        $.ajax({
            url     : data.url,
            type    : data.method,
            data    : data.parameter,
            success: function ()
            {
            },
            error: function()
            {
                swal('Are you sure you doing this the right way?');
            },
        });
    }
})