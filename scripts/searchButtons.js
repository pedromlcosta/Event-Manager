
function deleteButton(event){
	$.ajax({
		url: '../eventsIndex.php',
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

function joinButton(event){
	$.ajax({
		url: '../action_buttons.php',
		type: 'POST',
		data: {
			action: 'JOIN',
			userID: userID,
			eventID: eventID
		},
		dataType: 'json', // -> automatically parses response data!
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

function leaveButton(event){
	$.ajax({
		url: '../action_buttons.php',
		type: 'POST',
		data: {
			action: 'LEAVE',
			userID: userID,
			eventID: eventID
		},
		dataType: 'json', // -> automatically parses response data!
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

function removeButton(event){
	$.ajax({
		url: '../action_buttons.php',
		type: 'POST',
		data: {
			action: 'REMOVE',
			userID: userID,
			eventID: eventID
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


function inviteButton(event){
console.log("inviteButton",userID,eventID);
}

function showOwnerButtons(){
	showEditButton();
	showDeleteButton();
	showInviteButton();
}
function showEditButton(){
	$("#editButton").show();
	
}
function showDeleteButton(){
	$("#deleteButton").show();
}
function showJoinButton(){
	$("#joinButton").show();
}
function showLeaveButton(){
	$("#leaveButton").show();
}
function showRemoveButton(){
	 $("#removeButton").show();
}
function showInviteButton(){
	 $("#inviteButton").show();
}

function hideEditButton(){
	$("#form #editButton").hide();
	
}
function hideDeleteButton(){
	$("#deleteButton").hide();
}
function hideJoinButton(){
	$("#joinButton").hide();
}
function hideLeaveButton(){
	$("#leaveButton").hide();
}
function hideRemoveButton(){
	 $("#removeButton").hide();
}
function hideInviteButton(){
	 $("#inviteButton").hide();
}


function hideAll(){

	hideInviteButton();
	hideRemoveButton();
	hideLeaveButton();
	hideJoinButton();
	hideDeleteButton();
	hideEditButton();
}
function handleSubmits() {
	//On doc ready, add handlers
	$(document).ready(function() {
	$("#deleteButton").on("click",deleteButton); 
	$("#joinButton").on("click",joinButton); 
	$("#leaveButton").on("click",leaveButton); 
    $("#removeButton").on("click",removeButton); 
    $("#inviteButton").on("click",inviteButton); 
	});
	hideAll();
}