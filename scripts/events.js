function deleteButton(event) {
	$.ajax({
		url: 'action_buttons.php',
		type: 'POST',
		data: {
			action: 'DELETE',
			userID: userID,
			eventID: eventID
		},
		dataType: 'json', // -> automatically parses response data!
		success: function(data, textStatus, jqXHR) {
			console.log("success");

			//Abandonar Página
		},
		error: function(jqXHR, textStatus, errorThrown) {

			// Handle errors here
			console.log(jqXHR.responseText);
			console.log('ERRORS: ' + textStatus);
			// STOP LOADING SPINNER
		}
	});
}

function joinButton(event) {
	$.ajax({
		url: 'action_buttons.php',
		type: 'POST',
		data: {
			action: 'JOIN',
			userID: userID,
			eventID: eventID
		},
		success: function(data, textStatus, jqXHR) {

			showLeaveButton();
			hideJoinButton();
		},
		error: function(jqXHR, textStatus, errorThrown) {

			// Handle errors here
			console.log(jqXHR.responseText);
			console.log('ERRORS: ' + textStatus);
			// STOP LOADING SPINNER
		}
	});

}

function leaveButton(event) {
	$.ajax({
		url: 'action_buttons.php',
		type: 'POST',
		data: {
			action: 'LEAVE',
			userID: userID,
			eventID: eventID
		},
		success: function(data, textStatus, jqXHR) {
			hideLeaveButton();
			showJoinButton();

		},
		error: function(jqXHR, textStatus, errorThrown) {
			// Handle errors here
			console.log("ERROR HERE");
			console.log('ERRORS: ' + textStatus);
			// STOP LOADING SPINNER
		}
	});

}

function removeButton(event) {
	$.ajax({
		url: 'action_buttons.php',
		type: 'POST',
		data: {
			action: 'REMOVE',
			userID: userID,
			eventID: eventID
		},
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


function inviteButton(event) {
	console.log("inviteButton", userID, eventID);
}

function addCommentButton(event) {

}

function showOwnerButtons() {
	showEditButton();
	showDeleteButton();
	showInviteButton();
}

function showEditButton() {
	$("#editButton").show();

}

function showDeleteButton() {
	$("#deleteButton").show();
}

function showJoinButton() {
	console.log("show join button");
	$("#joinButton").show();
	hideLeaveButton();
}

function showLeaveButton() {
	$("#leaveButton").show();
	hideJoinButton();
}

function showRemoveButton() {
	$("#removeButton").show();
}

function showInviteButton() {
	$("#inviteButton").show();
	 
}

function hideEditButton() {
	$("#form #editButton").hide();
}

function hideDeleteButton() {
	$("#deleteButton").hide();
}

function hideJoinButton() {
	$("#joinButton").hide();
}

function hideLeaveButton() {
	$("#leaveButton").hide();
}

function hideRemoveButton() {
	$("#removeButton").hide();
}

function hideInviteButton() {
	$("#inviteButton").hide();
}

 

var event_id = null;
var COMMENTS_PER_PAGE = 2;
var currentPage = 1;
var totalPages = 1;
var loaded = null;


function listComments(comments) {

	console.log("kk");
	var commentNum = comments.length;
	var cList = $('#comment_list');
	console.log(cList);
	cList.empty();

	$.each(comments, function(i) {
		//Mudar aqui a class lel
		var li = $('<li class="list_event" id="li_event' +comments[i]['id'] +'"> </li>')
			.addClass('event_item')
			.appendTo(cList);

		var info = $('<div/>')
			.addClass('info')
			.append($('<div/>')
				.append($('<h4/>').text('Author').val('Author'))
				.append(comments[i]['fullname']))
			.append($('<div/>')
				.append($('<h4/>').text('Date').val('Date'))
				.append(comments[i]['data']))
			.append($('<div/>')
				.append($('<h4/>').text('Comment').val('Comment'))
				.append(comments[i]['comment']));

		//User image
		var cont = $('<div/>')
			.append($('<img src="' + comments[i]['url'] + '" alt="event" width="200" height="120">'))
			.append(info);

		li.append(cont);
	});

	
}

function loadCommentPageButtons() {
	//Number of pages it can go back or forward with the buttons, at once
	var numberBackForward = 2;
	numberBackForward = numberBackForward > totalPages - 1 ? totalPages - 1 : numberBackForward;

	var firstButton = currentPage - numberBackForward <= 1 ? 1 : currentPage - numberBackForward;
	var lastButton = currentPage + numberBackForward >= totalPages ? totalPages : currentPage + numberBackForward;

	/*
	console.log("Number of pages: " + totalPages);
	console.log(currentPage + numberBackForward);
	console.log("numberBackForward: " + numberBackForward);
	console.log("Current Page: " + currentPage);
	console.log("First Button " + firstButton);
	console.log("Last Button " + lastButton);
	*/


	$('#page_buttons').empty();
	for (var i = firstButton; i <= lastButton; i++) {

		if (i != currentPage) {
			$('#page_buttons').append('<button type="button" class="commentPageClick">' + i + '</button>');
		} else {
			$('#page_buttons').append('<button type="button" class="commentPageClick current">' + i + '</button>');
		}
	}

	// Handler only installed after buttons exist/are created
	$('.commentPageClick').on('click', function(e) {
		e.preventDefault();
		// Updates current page and refreshes events/buttons
		currentPage = parseInt($(this).context.textContent);
		console.log(currentPage);
		loadComments();
	});
}

function loadComments(event, comment_action) {

	//Searches for the action on both the event and comment_action parameters
	if (event == undefined || event.data == undefined) {
		var comment_action = comment_action != undefined ? comment_action : 'reload';
	} else {
		var comment_action = event.data.action != undefined ? event.data.action : 'reload';
	}

	var newComment = $('#commentTextArea').val();
	console.log(newComment);

	$.ajax({
		url: 'action_comments.php',
		type: 'POST',
		data: {
			action: comment_action,
			comment: newComment,
			commentsPerPage: COMMENTS_PER_PAGE,
			page: currentPage,
		},
		dataType: 'json', // -> automatically parses response data!
		success: function(data, textStatus, jqXHR) {
			if (typeof data.error === 'undefined') {
				// 1st Item returned is the total of events
				console.log(data);
				if (data.length > 0) {

					totalPages = Math.ceil(data[data.length - 1] / COMMENTS_PER_PAGE);
					console.log("Number of comments: " + data[data.length - 1]);

					data.pop();
				}
				console.log("Total Pages: " + totalPages);

				if (currentPage > totalPages) {
					currentPage = totalPages;
					loadComments();
				} else {
					loadCommentPageButtons();
					listComments(data);
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
		}
	});
}

function handleSubmits() {
	//On doc ready, add handlers
	$(document).ready(function() {

		$("#deleteButton").on("click", deleteButton);
		$("#joinButton").on("click", joinButton);
		$("#leaveButton").on("click", leaveButton);
		$("#removeButton").on("click", removeButton);
		$("#inviteButton").on("click", inviteButton);

		$("#addCommentButton").click({action: "addComment"},loadComments);
		loadComments();

	});

	



}
