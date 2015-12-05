var fullNameButtonPressed = false;
var passwordButtonPressed = false;


function fullNameButtonHandler(event) {
	$('#oldUserName').attr("placeholder", "Current Full Name");
	$('#newUserName').attr("placeholder", "New Full Name");

	$('#oldUserName').attr("name", "CHANGE_USER_FULLNAME");
	$('#newUserName').attr("name", "CHANGE_USER_FULLNAME");

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

function hideForms() {
	$('#changeNameForm').hide();
	$('#changePassWord').hide();
}

function saveUserNameChangesHandler(event) {
	console.log("wrong one?");
	event.preventDefault();
	$.ajax({
		url: 'action_buttons.php',
		type: 'POST',
		data: {
			action: $('#oldUserName').attr("name"),
			oldName: $('#oldUserName').val(),
			newName: $('#newUserName').val(),
			userID: userID
		},
		dataType: 'text',
		success: function(data, textStatus, jqXHR) {
			//console.log("success");
			/*
			if(data == 'Success'){
				location.reload();
			}else{
				$('#errorMessage').empty();
				$('#errorMessage').append(data);
			}

			*/
			//Abandonar Página
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
		dataType: 'text',
		success: function(data, textStatus, jqXHR) {
			if (data != 'Success') {
				$('#errorMessage').empty();
				$('#errorMessage').append(data);
				console.log("Not success");
			}
			console.log(data);

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
		$('#saveUserNameChanges').on('click', saveUserNameChangesHandler);
		$('#savePasswordChanges').on('click', savePasswordChangesHandler);
	});
}
