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

//TODO: make functions for a number of arguments that takes the colors

function resetButtonColor(button_selector) {
	$(button_selector).css({
		"background": "#FF6",
		"color": "#006bb3"
	});
}

function setButtonColor(button_selectors, background_color, text_color) {
	$(button_selectors).css({
		"background": background_color !== undefined ? background_color : "#006bb3",
		"color": text_color !== undefined ? text_color : "#FFF"
	});
}

var registerSelected = false;
var loginSelected = false;

function clickedRegister(event) {
	// Reset Login coloration
	resetButtonColor('#login_button');
	loginSelected = false;
	// Activate Register coloration
	setButtonColor('#register_button');
	registerSelected = true;
}

function clickedLogin(event) {
	// Reset Register coloration
	resetButtonColor('#register_button');
	registerSelected = false;
	//Activate Login coloration
	setButtonColor('#login_button');
	loginSelected = true;
}

function hoveredRegister(event) {
	if (!registerSelected)
		setButtonColor('#register_button', '#80aaff');
}

function hoveredLogin(event) {
	if (!loginSelected)
		setButtonColor('#login_button', '#80aaff');
}

function unhoveredRegister(event) {
	if (!registerSelected)
		resetButtonColor('#register_button');
}

function unhoveredLogin(event) {
	if (!loginSelected)
		resetButtonColor('#login_button');
}

function onReadyAddHandlers() {
	//On doc ready, add handlers
	$(document).ready(function() {

		// REGISTER SUBMIT HANDLER
		$('#register form').submit(registerHandler);

		// LOGIN SUBMIT HANDLER
		$('#login form').submit(loginHandler);

		//REGISTER BUTTON CLICK HANDLER
		$('#register_button').click(clickedRegister);

		//LOGIN BUTTON CLICK HANDLER
		$('#login_button').click(clickedLogin);

		//REGISTER BUTTON HOVER HANDLER
		$('#register_button').hover(hoveredRegister, unhoveredRegister);

		//LOGIN BUTTON HOVER HANDLER
		$('#login_button').hover(hoveredLogin, unhoveredLogin);

		/*
		$(':not(#user_fields *)').click(function() {
			resetButtonColor('#register_button');
			resetButtonColor('#login_button');
		});
*/


	});
}
