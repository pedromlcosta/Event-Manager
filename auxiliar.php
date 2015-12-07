<?php

 $delimiters="[\s,\/,\|]";
 $imageExtension =array('jpg','png','jpeg','gif');
 $maxDistance=2;
 $destEventFolder='database/event_images/';
  function isLogged(){
    return isset($_SESSION['userID']);
  }

  function validateTypes($type){
  	 $validTypes=getTypes();

    foreach($validTypes as $typeDesc ){
        if($typeDesc == $type){
           return array(true);
        }
    }
       return array(false,' Invalid Type'); 
  }
  function validateDate($date, $format = 'Y-m-d'){

    $d = DateTime::createFromFormat($format, $date);
    if( $d && $d->format($format) == $date)
    	return array(true);
    else
    	return array(true,'Invalid Date');
}

  function valiateCheckBox($checkBox){
  	 if (!isset($checkBox))
        $privateValue = 0;
    else
        $privateValue = parseCheckBox($checkBox);

    return $privateValue;
  }

  function parseCheckBox($value){

    if ($value == 'on')
        return 1;
    else
        return 0;
}
	
 function getErrorMessage($array){
 	$message='';
 	foreach($array as $errorMessage){
 		if(!$errorMessage[0]){
 			$message=$message.$errorMessage[1].'<br>';
 		}

 	}
		return $message;
 }
 function validateUserInput($input){
      if ( preg_match ("/^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]+$/", $input)) {
      // ERROR: Name can only contain letters Numbers and spaces
        return false;
    }
    return true;
}

function validateImageUpload(){

  if(!isset($_FILES["fileToUpload"])){

    return array(false, "No Image Input Found");

  }else{
    // CHECK POSSIBLE ERRORS
    $error = $_FILES["fileToUpload"]['error'];

      switch ($error) {
      case 0:
          // OK: do Nothing
          break;
      case 4:
          return array(false, "No Image Selected");
          break;
      case 1:
          return array(false, "Max Upload Size Exceeded");
          break;
        case 2:
          return array(false, "Max Upload Size Exceeded");
          break;
        case 3:
          return array(false, "Error Uploading: File uploaded partially");
          break;
        case 7:
          return array(false, "Error Uploading: Server failed to upload");
          break;
        case 7:
          return array(false, "Error Uploading: An extension stopped the upload");
          break;
        default:
          break;
      }
  
  }
  
  // FURTHER MANUAL CHECKS
  if($_FILES["fileToUpload"]["name"] != ''){

    // CHECKING IF FILE IS REALLY AN IMAGE    
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check === false) {
          return array(false, "The uploaded file is not an image");
      }
      //TODO: uppercase or lowercase
      $imageFileType = pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION);
      /*
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        return array(false, "Only Valid image types are allowed");
    }
    */
       // CHECKING FILE SIZE
    if ($_FILES["fileToUpload"]["size"] > 3000000) {
        return array(false, "Max File Size exceeded");
    }
  }

  return array(true, "Success");

}

function uploadImageFile($destinationFolder, $action, $rowID){

    $target_dir = $destinationFolder;
    $imageFileType = pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION);

    // CREATING PSEUDO-RANDOM NAME FOR FILE
    $imageFileName = bin2hex(openssl_random_pseudo_bytes(8));
    $target_file = $target_dir . $imageFileName . "." . $imageFileType;
  
    while(file_exists($target_file)){
      $imageFileName = bin2hex(openssl_random_pseudo_bytes(8));
      $target_file = $target_dir . $imageFileName . "." . $imageFileType;
    }
    
    // Save on DB -> on edits, deletes the images that existed before
    if($action == 'edit_user'){
      deleteUserImage($rowID);
      updateUserImage($rowID, $target_file);
    }else if ($action == 'edit_event'){
      deleteEventImage($rowID);
      updateEventImage($rowID);
    }
  
    // Move to folder
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

    return $target_file;
}

?>