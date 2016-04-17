
var  clipboard = new Clipboard('.copy');

clipboard.on('success', function(e) {
	alert('copied');
});
