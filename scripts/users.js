var fullNameButtonPressed = false;
var passwordButtonPressed = false;
var saveImageButtonPressed = false;

function fullNameButtonHandler(event) {

	if (!fullNameButtonPressed) {
		$('#changeNameForm').show();
		fullNameButtonPressed = true;
	} else {
		fullNameButtonPressed = false;
		$('#changeNameForm').hide();
	}
}

function passwordButtonHandler(event) {

	if (!passwordButtonPressed) {
		$('#changePassWord').show();
		passwordButtonPressed = true;
	} else {
		passwordButtonPressed = false;
		$('#changePassWord').hide();
	}

}

function imageButtonHandler(event){

	if(!saveImageButtonPressed){
		$('#changeImageForm').show();
		saveImageButtonPressed=true;
	}
	else{
		saveImageButtonPressed=false;
		$('#changeImageForm').hide();
	}

}

function hideForms() {
	$('#changeNameForm').hide();
	$('#changePassWord').hide();
	$('#changeImageForm').hide();
}

function saveImageChangesHandler(event) {

	event.stopPropagation(); // Stop stuff happening
	event.preventDefault(); // Totally stop stuff happening

	// START A LOADING SPINNER HERE

	$.ajax({
		url: 'action_buttons.php',
		type: 'POST',
		data: new FormData(this),
		cache: false,
		processData: false, // Don't process the files
		contentType: false, // Set content type to false as jQuery will tell the server its a query string request
		success: function(data, textStatus, jqXHR) {
			if (typeof data.error === 'undefined') {
				// Success so call function to process the form
				//emptyStatus();
				//$('#messageStatus').prepend(data);
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

function saveUserNameChangesHandler(event) {
	
	event.preventDefault();
	$.ajax({
		url: 'action_buttons.php',
		type: 'POST',
		data: {
			action: "CHANGE_USER_FULLNAME",
			password: $('#currentPassword').val(),
			newName: $('#newUserName').val(),
		},
		dataType: 'json',
		success: function(data, textStatus, jqXHR) {
				console.log(data);
				// data[0] is true or false for success, data[1] is the message
				if (data[0]) {
					location.reload();
				} else {
					$("#errorMessage").empty();
					$("#errorMessage").show();
					$("#errorMessage").html(data[1]);
					$("#errorMessage").delay(2000).fadeOut("slow");
				}

		},
		error: function(jqXHR, textStatus, errorThrown) {

			// Handle errors here
			console.log(jqXHR.responseText);
			console.log('USER ERRORS: ' + textStatus);
			// STOP LOADING SPINNER
		}
	});
}

function savePasswordChangesHandler(event) {
	event.preventDefault();
	var oldPassVal = $('#oldPass').val();
	var newPassVal = $('#newPass').val()
	var confirmPassVal =  $('#typeAgainPass').val();

	console.log(oldPassVal + " " + newPassVal);
	$.ajax({
		url: 'action_buttons.php',
		type: 'POST',
		data: {
			action: 'CHANGE_USER_PASSWORD',
			userID: userID,
			oldPass: oldPassVal,
			newPass: newPassVal,
			confirmPass: confirmPassVal,
		},
		dataType: 'json',
		success: function(data, textStatus, jqXHR) {
			$("#errorMessage").empty();
			$("#errorMessage").show();
			$("#errorMessage").html(data[1]);
			$("#errorMessage").delay(2000).fadeOut("slow");

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

function handlers() {
	$(document).ready(function() {
		hideForms();
		$('#fullName_button').on('click', fullNameButtonHandler);
		$('#password_button').on('click', passwordButtonHandler);
		$('#image_button').on('click', imageButtonHandler);
		$('#saveUserNameChanges').on('click', saveUserNameChangesHandler);
		$('#savePasswordChanges').on('click', savePasswordChangesHandler);
		$('#saveImageChanges').on('click', saveImageChangesHandler);

	});
}
