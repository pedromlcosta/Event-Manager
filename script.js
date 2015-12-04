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

	
	console.log("Number of pages: " + totalPages);
	console.log("numberBackForward+currentPage = " + currentPage + numberBackForward);
	console.log("numberBackForward: " + numberBackForward);
	console.log("Current Page: " + currentPage);
	console.log("First Button " + firstButton);
	console.log("Last Button " + lastButton);
	

	$('#page_buttons').empty();
	for (var i = firstButton; i <= lastButton; i++) {

		if (i != currentPage) {
			$('#page_buttons').append('<button type="button" class="pageClick">' + i + '</button>');
		} else {
			$('#page_buttons').append('<button type="button" class="pageClick current">' + i + '</button>');
		}
	}

	// Handler only installed after buttons exist/are created
	$('.pageClick').on('click', function(e) {
		e.preventDefault();
		// Updates current page and refreshes events/buttons
		currentPage = parseInt($(this).context.textContent);
		eventTabHandler('undefined', true);
	});

	//$(#page_buttons);
}

function respondToInvite(action, events) {
	console.log(action + " " + events);
	$.ajax({
		url: 'action_eventInvites.php',
		type: 'POST',
		data: {
			response: action,
			event_ID: events
		},
		dataType: 'json', // -> automatically parses response data!
		success: function(data, textStatus, jqXHR) {
			if (typeof data.error === 'undefined') {
				//console.log(data);
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

function listEventsUnderTab(events) {

	//console.log(events);
	var eventNum = events.length;
	var cList = $('#event_list');
	cList.empty();

	$.each(events, function(i) {
		var li = $('<li class="list_event" id="li_event' +events[i]['id'] +'"> </li>')
			.addClass('event_item')
			.appendTo(cList);

		var info = $('<div/>')
			.addClass('info')
			.append($('<div/>')
				.append($('<a href="event'+events[i]['id']+'.php">' + events[i]['title'] +' </a>')))
			.append($('<div/>')
				.append($('<h4/>').text('Type').val('Type'))
				.append(events[i]['type']))
			.append($('<div/>')
				.append($('<h4/>').text('Date').val('Date'))
				.append(events[i]['data']))
			.append($('<div/>')
				.append($('<h4/>').text('Number of Users').val('Number Of Users'))
				.append(events[i]['numberUsers']))
			.append($('<div/>')
				.append($('<h4/>').text('Author').val('Author'))
				.append(events[i]['fullname']));

			if(selectedTab != "#customSearch" && selectedTab != "#otherEvents"){
				if(events[i]['attending_status'] == 1){
					info.append("Attending");
				}else{
					info.append("Not attending");
				}
				
			}

		if (selectedTab == '#invitedEvents') {
			info.append($('<div/>')
				.append($('<a href="javascript:void(0,' + events[i]['id'] + ')" class="inviteResponse removeEvent" > Remove Event </a>')));

			info.append($('<div/>')
				.append($('<a href="javascript:void(1,' + events[i]['id'] + ')" class="inviteResponse acceptEvent" > Accept Invite </a>')));

		}

		var cont = $('<div/>')
			.append($('<img src="images/logo.png" alt="event" width="200" height="120">'))
			.append(info);

		li.append(cont);
	});

	//Bind response buttons outside cycle, not to repeat them

	$('.inviteResponse').on('click', function(event) {

		var hrefValues = $(this).attr("href").replace("javascript:void(","").replace(")", "");
		hrefValues = hrefValues.split(',');

		respondToInvite(hrefValues[0], hrefValues[1]); // Code 1 is for removing

		//hide the element here with animation, THEN the next line is called
		$('#li_event' + hrefValues[1]).fadeOut('slow').delay(1000);

		setTimeout(eventTabHandler,1000, 'undefined', true);
	});

}

// TODO: updateTotalCurrentPages function, using query, blah blah, just maybe

// Reload Events for the specified tab, using the specified parameters
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
					
					if (data.length > 0) {

						totalPages = Math.ceil(data[data.length - 1]['numEvents'] / EVENTS_PER_PAGE);
						//console.log("Number of events: " + data[data.length - 1]['numEvents']);

						data.pop();
					}
					//console.log("Total Pages: " + totalPages);

					//TODO: Maybe move this following part to a separate function
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

// Clicked to refresh tab. Gets query parameters and calls the query and refresh function
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

	/*
    console.log(selectedTab);
	console.log(order);
	console.log(typeFilters);
	*/

	// Querying Database for the tab events and filling 
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
