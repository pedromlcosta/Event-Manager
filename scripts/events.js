function setPrivateCheckBox(){
		if(isPrivate==1) 
			$('#private').attr('checked', true);
		else
			$('#private').attr('checked', false);
}


function eventHandlers() {
	//On doc ready, add handlers
	$(document).ready(function() {
	 setPrivateCheckBox();
	});
}