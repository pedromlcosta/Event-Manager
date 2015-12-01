
function editButton(event){
console.log("editButton",userID,eventID);
}

function deleteButton(event){
console.log("deleteButton",userID,eventID);
}

function joinButton(event){
console.log("joinButton",userID,eventID);
}

function leaveButton(event){
console.log("leaveButton",userID,eventID);
}



function handleSubmits() {
	alert("HELLLO");
	console.log("leaveButton",userID,eventID);
	//On doc ready, add handlers
	$(document).ready(function() {
	 ('#editButton').submit(editButton); 
	 ('#deleteButton').submit(deleteButton); 
	 ('#joinButton').submit(joinButton); 
	 ('#leaveButton').submit(leaveButton); 
	});
}