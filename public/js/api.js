var clipboard = new Clipboard(".copy");

clipboard.on("success", function() {
    swal("Token copied successfully");
});