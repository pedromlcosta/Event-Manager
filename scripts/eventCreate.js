var imageTooBig = false;
var MAX_FILE_SIZE_EDIT = 8000000;

function showMessage() {
	$('#errorMessageCreateEvent').show();

}

function hideMessage() {
	$('#errorMessageCreateEvent').empty();
	$('#errorMessageCreateEvent').hide();
}

function eventFormHandler(event) {
	
	event.stopPropagation(); // Stop stuff happening
	event.preventDefault(); // Totally stop stuff happening

	if (imageTooBig) {
		$("#errorMessageCreateEvent").empty();
		$("#errorMessageCreateEvent").show();
		$("#errorMessageCreateEvent").html("The file is too big for upload");
		$('#errorMessageCreateEvent').css({"text-align":"center", "font-weight":"bold", "font-size":"20px"});
		$("#errorMessageCreateEvent").delay(3000).fadeOut("slow");
	} else {
		// START A LOADING SPINNER HERE
		$.ajax({
			url: $("#eventEditAdd").attr('action'),
			type: 'POST',
			data: new FormData(this),
			cache: false,
			processData: false, // Don't process the files
			contentType: false, // Set content type to false as jQuery will tell the server its a query string request
			success: function(data, textStatus, jqXHR) {
				if (typeof data.error === 'undefined') {
					var data = JSON.parse(data);
					
					if(data[0] == true){
						window.location.href = "event_page.php?eventID=" + data[2];
					}else{
						$("#errorMessageCreateEvent").empty();
						$("#errorMessageCreateEvent").show();
						$("#errorMessageCreateEvent").html(data[1]);
						$("#errorMessageCreateEvent").delay(3000).fadeOut("slow");
					}
					
					console.log(data);
					
				} else {
					// Handle errors here
					console.log('ERRORS: ' + data.error);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// Handle errors here
				console.log('ERRORS: ' + textStatus);
				console.log("ERRORS THROWN: " + errorThrown);
				// STOP LOADING SPINNER
			}
		});
	}
}

function handleSubmits() {
	//On doc ready, add handlers
	$(document).ready(function() {
		$("#eventEditAdd").on("submit", eventFormHandler);


		$('#eventImg').bind('change', function() {
			
			if (this.files[0].size > MAX_FILE_SIZE_EDIT)
				imageTooBig = true;
			else
				imageTooBig = false;
		});


	});





}
