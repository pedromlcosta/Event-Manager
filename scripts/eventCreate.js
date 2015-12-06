var imageTooBig=false;
function showMessage(){
	$('#errorMessageCreateEvent').show();

}
function hideMessage(){
	$('#errorMessageCreateEvent').empty();
	$('#errorMessageCreateEvent').hide();
}

function eventFormHandler(event) {
	console.log("Calling submit");
	event.stopPropagation(); // Stop stuff happening
	event.preventDefault(); // Totally stop stuff happening

	if (imageTooBig) {
		$("#errorMessageCreateEvent").empty();
		$("#errorMessageCreateEvent").show();
		$("#errorMessageCreateEvent").html("The file is too big for upload");
		$("#errorMessageCreateEvent").delay(2000).fadeOut("slow");
	} else {
		// START A LOADING SPINNER HERE
		$.ajax({
			url: 'action_createEvents.php',
			type: 'POST',
			data: new FormData(this),
			cache: false,
			processData: false, // Don't process the files
			contentType: false, // Set content type to false as jQuery will tell the server its a query string request
			success: function(data, textStatus, jqXHR) {
				if (typeof data.error === 'undefined') {
					console.log(data);
					var data = JSON.parse(data);

			 			console.log(data);
						$("#errorMessageCreateEvent").empty();
						$("#errorMessageCreateEvent").show();
						$("#errorMessageCreateEvent").html(data);
						$("#errorMessageCreateEvent").delay(2000).fadeOut("slow");
					 

				} else {
					// Handle errors here
					console.log('ERRORS: ' + data.error);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// Handle errors here
				console.log('ERRORS: ' + textStatus);
				console.log("ERRORS THROWN: "+errorThrown);
				// STOP LOADING SPINNER
			}
		});
	}
}
function handleSubmits() {
	//On doc ready, add handlers
	$(document).ready(function() {
		$("#eventEditAdd").on("submit", eventFormHandler);


	});

	



}
