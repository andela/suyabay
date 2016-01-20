$(document).ready(function() {
	$(".fb-share").on("click", function  () {
		var desc = $(this).attr('data-desc');
		var name = $(this).attr('data-name');
		var img = $(this).attr('data-img');
		var audio = $(this).attr('data-audio');

		$.ajaxSetup({ cache: true });
			  $.getScript('//connect.facebook.net/en_US/sdk.js', function() {
			    FB.init({
			      appId: '505159549666382',
			      version: 'v2.5'
			    });
			    FB.ui({
					  method: 'share',
					  display: 'popup',
					  href: audio,
					  caption: name,
					  description: desc,
					  picture: img
					});
			  });
	});

	$(".twtr-share").on("click", function () {
		var desc = $(this).attr('data-desc').trim();
		var img = $(this).attr('data-img');
		var audio = $(this).attr('data-audio');

		 if (desc.length >= 75) {
		 		desc = desc.substr(0, 75) + '.. ';
		 }

		 var url = 'https://twitter.com/intent/tweet?text=' + encodeURIComponent(desc) + '&url=' + audio + '&hashtags=suyabay';
		 window.open(url,'_blank');
	});
});