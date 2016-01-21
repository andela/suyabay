$(document).ready(function() {
    $('.fb-share').on('click', function() {
        var desc = $(this).attr('data-desc');
        var name = $(this).attr('data-name');
        var img = $(this).attr('data-img');
        var audio = $(this).attr('data-audio');

        $.ajaxSetup({
            cache: true
        });

        $.getScript('//connect.facebook.net/en_US/sdk.js', function() {
            window.FB.init({
                appId: '505159549666382',
                version: 'v2.5'
            });
            window.FB.ui({
                method: 'share',
                display: 'popup',
                href: audio,
                caption: name,
                description: desc,
                picture: img
            });
        });
    });

    $('.twtr-share').on('click', function() {
        var desc = $(this).attr('data-desc').trim();
        var audio = $(this).attr('data-audio');

        if (desc.length >= 75) {
            desc = desc.substr(0, 75) + '.. ';
        }

        var baseUrl = 'https://twitter.com/intent/tweet?text=';
        desc = encodeURIComponent(desc);
        var link = '&url=' + audio + '&hashtags=suyabay';

        window.open(baseUrl + desc + link, '_blank');
    });
});