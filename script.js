function hideLogin() {
	$("#login").hide();
}

function hideLogout() {
	$("#logout").hide();
}

function hideRegister() {
	$("#register").hide();
}

function emptyStatus() {
	$(document).ready(function() {
		$("#messageStatus").empty();

	});
}

function showUsername() {

}

function showLogin() {
	$("#login").show();
}

function showLogout() {
	$("#logout").show();
}

function showRegister() {
	$("#register").show();
}

// FUNCTION TO SUBMIT USING AJAX

function registerHandler(event) {

	event.stopPropagation(); // Stop stuff happening
	event.preventDefault(); // Totally stop stuff happening

	// START A LOADING SPINNER HERE

	$.ajax({
		url: 'action_register.php',
		type: 'POST',
		data: new FormData(this),
		cache: false,
		processData: false, // Don't process the files
		contentType: false, // Set content type to false as jQuery will tell the server its a query string request
		success: function(data, textStatus, jqXHR) {
			if (typeof data.error === 'undefined') {
				// Success so call function to process the form
				emptyStatus();
				$('#messageStatus').prepend(data);
				console.log(data);
			} else {
				// Handle errors here
				console.log('ERRORS: ' + data.error);
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			// Handle errors here
			console.log('ERRORS: ' + textStatus);
			// STOP LOADING SPINNER
		}
	});
}

function loginHandler(event) {

	event.stopPropagation(); // Stop stuff happening
	event.preventDefault(); // Totally stop stuff happening

	$.ajax({
		url: 'action_login.php',
		type: 'POST',
		data: new FormData(this),
		cache: false,
		processData: false,
		contentType: false,
		success: function(data, textStatus, jqXHR) {
			if (typeof data.error === 'undefined') {

				var loggedIn = JSON.parse(data);
				if (loggedIn) {
					location.reload();
				} else {
					emptyStatus();
					$("#messageStatus").prepend("Username/Password combination not found.");
				}
				console.log(loggedIn);

			} else {
				// Handle errors here
				console.log('ERRORS: ' + data.error);
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			// Handle errors here
			console.log('ERRORS: ' + textStatus);
			// STOP LOADING SPINNER
		}
	});

}

function clickedRegister(event) {
	console.log("hey");
}

function onReadyAddHandlers() {
	//On doc ready, run handler
	$(document).ready(function() {

		// REGISTER HANDLER
		$('#register form').submit(registerHandler);

		// LOGIN HANDLER
		$('#login form').submit(loginHandler);


		//REGISTER BUTTON HANDLER
		$('#registerbutton').click(clickedRegister);

	});
}





function mouseOverRegister(event) {

}

function clickedLogin(event) {

}

function mouseOverLogin(event) {

}
