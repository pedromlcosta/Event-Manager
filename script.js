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

var userID = null;
var selectedTab = null;
var order = 'Date';
var typeFilters = [];
var EVENTS_PER_PAGE = 5;
var currentPage = 1;
var totalPages = 1;
var loaded = null;

function updatePageButtons() {
	//Number of pages it can go back or forward with the buttons, at once
	var numberBackForward = 2;
	numberBackForward = numberBackForward > totalPages - 1 ? totalPages - 1 : numberBackForward;

	// Se ultrapassar os limites que devia (1a pagina possivel e ultima), nao consegue
	var firstButton = currentPage - numberBackForward <= 1 ? 1 : currentPage - numberBackForward;
	var lastButton = currentPage + numberBackForward >= totalPages ? totalPages : currentPage + numberBackForward;

	/*
	console.log("Number of pages: " + totalPages);
	console.log("First Button " + firstButton);
	console.log("Last Button " + lastButton);
	*/
	
	$('#page_buttons').empty();
	for (var i = firstButton; i <= lastButton; i++) {

		if(i!=currentPage){
		$('#page_buttons').append('<button type="button" class="pageClick">' + i + '</button>');
		}else{
			$('#page_buttons').append('<button type="button" class="pageClick current">' + i + '</button>');
		}
	}

	// Handler only installed after buttons exist/are created
	$('.pageClick').on('click', function(e) {
		e.preventDefault();
		// Updates current page and refreshes events/buttons
		currentPage = $(this).context.textContent;
		eventTabHandler('undefined', true);
	});

	//$(#page_buttons);
}

function listEventsUnderTab(events) {

	//console.log(events);

	var cList = $('#event_list');
	cList.empty();

	$.each(events, function(i) {
		var li = $('<li/>')
			.addClass('event_item')
			.appendTo(cList);

		var info = $('<div/>')
			.addClass('info')
			.append($('<div/>')
				.append($('<h4/>').text('Title').val('Title'))
				.append(events[i]['title']))
			.append($('<div/>')
				.append($('<h4/>').text('Date').val('Date'))
				.append(events[i]['data']))
			.append($('<div/>')
				.append($('<h4/>').text('Number of Users').val('Number Of Users'))
				.append(events[i]['numberUsers']))
			.append($('<div/>')
				.append($('<h4/>').text('Author').val('Author'))
				.append(events[i]['fullname']));

		var a = $('<a/>')
			.attr("href","event"+events[i]['id']+".php")
			.append($('<img src="images/logo.png" alt="event" width="150" height="90">'))
			.append(info);

			li.append(a);
	});
}

function queryEventForTab(tabID, eventOrder, eventTypeFilters, update) {

	// Run Handler only if: wants to update info or current tab isn't yet loaded with info
	if (loaded != tabID || update == true) {

		//Can only send text, array has to go on JSON format!
		var tempFilters = JSON.stringify(eventTypeFilters);
		$.ajax({
			url: 'action_selectTab.php',
			type: 'POST',
			data: {
				tab: tabID,
				order: eventOrder,
				eventsPerPage: EVENTS_PER_PAGE,
				page: currentPage,
				typeFilters: tempFilters
			},
			dataType: 'json', // -> automatically parses response data!
			success: function(data, textStatus, jqXHR) {
				if (typeof data.error === 'undefined') {
					// 1st Item returned is the total of events
					//console.log(data);
					if (data.length > 0) {

						console.log("data",data.length);
						//Update total number of pages
						// ????????????????????????
						totalPages = Math.ceil(data.length / EVENTS_PER_PAGE);

						//totalPages = Math.ceil(data[data.length - 1]['numEvents'] / EVENTS_PER_PAGE);
						//console.log("Number of events: " + data[data.length - 1]['numEvents']);

						//Why this pop?
						//data.pop();
					}
					//console.log("Total Pages: " + totalPages);

					//IF USER CLICKED ON A NO LONGER EXISTANT PAGE (page 5, but the only event there was deleted meanwhile)
					if (currentPage > totalPages) {
						currentPage = totalPages;
						queryEventForTab(tabID, eventOrder, eventTypeFilters, true);
					} else {
						//Else, user clicked on a valid page and updates/shows as it should
						updatePageButtons();
						listEventsUnderTab(data);
						loaded = tabID;
					}
				} else {
					// Handle errors here
					console.log('ERRORS: ' + data.error);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// Handle errors here
				console.log(jqXHR.responseText);
				console.log('ERRORS: ' + textStatus);
				// STOP LOADING SPINNER
			}
		});
	}
}

// Clicked a tab. Gets events for it and displays them
function eventTabHandler(event, update) {

	var eventsUpdate = null;

	if (event == undefined || event.data == undefined) {
		var eventsUpdate = update != undefined ? update : false;
	} else {
		var eventsUpdate = event.data.update != undefined ? event.data.update : false;
	}

	// Updating order selected -> selects currentTab div, then the input of it
	order = $('.tab-section.current .sortSelection input[name=sortType]:checked').val();
	// Updating type of events selected
	typeFilters = $('.tab-section.current input:checkbox:checked').map(function() {
		return $(this).val();
	}).get();

    console.log(selectedTab);
	console.log(order);
	console.log(typeFilters);

	// Querying Database for the tab events
	queryEventForTab(selectedTab, order, typeFilters, eventsUpdate);

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

		//TABS DISPLAY
		$('.tab-section').hide();

		//IMPORTANT: ORDER OF THESE NEXT 3 FUNCTIONS IS IMPORTANT!
		$('#tabs a').click(function(e) {
			currentPage = 1;
			// Reset the current class from link and div
			// Div current removed first, otherwise there would be no current href to get to it
			$($('#tabs a.current').attr('href')).removeClass('current');
			$('#tabs a.current').removeClass('current');

			// Hide divs from previous tab and show the new one
			$('.tab-section:visible').hide();
			$(this.hash).show();

			// Update current class from link and div
			$(this).addClass('current');
			$($('#tabs a.current').attr('href')).addClass('current');
			selectedTab = $('#tabs a.current').attr('href');
			e.preventDefault();
		})

		$('#tabs a').click(eventTabHandler);

		$('.typeSelection label').click({
			update: true
		}, eventTabHandler);
		$('.sortSelection label').click({
			update: true
		}, eventTabHandler);

		$('#tabs a').filter(':first').click();
	});
}
