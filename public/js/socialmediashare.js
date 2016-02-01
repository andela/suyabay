$(document).ready(function() {
    $('.fb-share').on('click', function(event) {

        event.preventDefault();

        var desc = $(this).attr('data-desc');
        var name = $(this).attr('data-name');
        var img = $(this).attr('data-img');
        var url = $(this).attr('data-url');

        $.ajaxSetup({
            cache: true
        });

        $.getScript('//connect.facebook.net/en_US/sdk.js', function() {
            window.FB.init({
                appId: '1691359924434970',
                version: 'v2.5'
            });
            window.FB.ui({
                method: 'share',
                display: 'popup',
                href: url,
                caption: name,
                description: desc,
                picture: img
            });
        });
    });

    $('.twtr-share').on('click', function(event) {

        event.preventDefault();

        var desc = $(this).attr('data-desc').trim();
        var url = $(this).attr('data-url');

        if (desc.length >= 75) {
            desc = desc.substr(0, 75) + '.. ';
        }

        var baseUrl = 'https://twitter.com/intent/tweet?text=';
        desc = encodeURIComponent(desc);
        var link = '&url=' + url + '&hashtags=suyabay';

        window.open(baseUrl + desc + link, '_blank');
    });
});
