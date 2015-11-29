function hideLogin() {
	$("#login").hide();
	$("#login #username").val('');
	$("#login #password").val('');
}

function hideLogout() {
	$("#logout").hide();
}

function hideRegister() {
	$("#register").hide();
	$("#register #username").val('');
	$("#register #password").val('');
	$("#register #fullname").val('');
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

// BUTTON FUNCTIONS AND HANDLERS

var registerSelected = false;
var loginSelected = false;

var buttonDefaultColors;

function resetButtonColor(button_selector) {
	$(button_selector).css({
		"background": buttonDefaultColors[0],
		"color": buttonDefaultColors[1]
	});
}

function setButtonColor(button_selectors, background_color, text_color) {
	$(button_selectors).css({
		"background": background_color !== undefined ? background_color : "#006bb3",
		"color": text_color !== undefined ? text_color : "#FFF"
	});
}

function clickedRegister(event) {
	if (!registerSelected) {
		// Reset Login coloration
		resetButtonColor('#login_button');
		loginSelected = false;
		// Activate Register coloration
		setButtonColor('#register_button');
		hideLogin();
		showRegister();
		emptyStatus();
	} else {
		resetButtonColor('#register_button');
		hideRegister();
		emptyStatus();
	}

	registerSelected = !registerSelected;
}

function clickedLogin(event) {

	if (!loginSelected) {
		// Reset Register coloration
		resetButtonColor('#register_button');
		registerSelected = false;
		//Activate Login coloration
		setButtonColor('#login_button');
		hideRegister();
		showLogin();
		emptyStatus();
	} else {
		resetButtonColor('#login_button');
		hideLogin();
		emptyStatus();
	}

	loginSelected = !loginSelected;
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

// TABS HANDLERS

var EVENTS_PER_PAGE = 10
var loaded = null;

function queryEventForTab(tabID){
	//If tab isn't loaded yet, loads it with info from queries
	if (loaded != tabID) {
		$.ajax({
			url: 'action_selectTab.php',
			type: 'POST',
			data: {
				tab: tabID
			},
			dataType: 'text',
			success: function(data, textStatus, jqXHR) {
				if (typeof data.error === 'undefined') {
					// Array returned from action_selectTab
					var events = JSON.parse(data);
					//console.log(events);
					for(var i = 0; i<events.length; i++){
						console.log(events[i]['title']);
					}
					loaded = tabID;
					//TODO: funcao que recebe array e faz push dos eventos para a lista -> tem de levar pagina
					//Para este efeito, criar variavel global da pagina em que esta...

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
}

// Uses ID of tab to get the number of it
function eventTabHandler(event){
	queryEventForTab(event.target.id);
}


function onReadyAddHandlers() {
	//On doc ready, add handlers
	$(document).ready(function() {
		//Keeping CSS default colors for buttons
		buttonDefaultColors = [$('#login_button').css("background-color"), $('#login_button').css("color")];

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

		$('#tabs a').click(eventTabHandler);

		//TABS DISPLAY
		$('.tab-section').hide();

		$('#tabs a').click(function(e) {
			$('#tabs a.current').removeClass('current');
			$('.tab-section:visible').hide();
			$(this.hash).show();
			$(this).addClass('current');
			e.preventDefault();
		}).filter(':first').click();
	});
}
