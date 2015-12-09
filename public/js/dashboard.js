/*
| Script By Emeke Osuagwu @dev_emeka emekaosuagwuandela@gmail.com
| Description LoginAndSigup script in create to handel ajax call
| for Suyabay Login and Register funtionality and also and Email for
| user registeration.
*/


/*
| ajaxLogic
| Process ajaxCall data and return feedback base on the data
| receives 3 parameter from ajaxClass
| @data is the array of user infomation \\console.log(data) to see properties
| @response is the ajax response coming from the api end ponit
| @funtionName is the name of the fuction called
*/

function registerUser ()
{
	swal("Registration Complete", "", "success")
	window.location = "/dashboard";
}

/*
	Delete function
*/
function deleteEpisode()
{
	swal(
	{
		title: "Are you sure?",
		text: "You will not be able to recover this imaginary file!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Yes, delete it!",
		closeOnConfirm: false
	},
	function()
	{
		swal("Deleted!", "Your imaginary file has been deleted.", "success");
	});
}
