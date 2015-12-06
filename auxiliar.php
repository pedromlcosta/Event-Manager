<?php

 $delimiters="[\s,\/,\|]";
 $imageExtension =array('jpg','png','jpeg','gif');
 $maxDistance=2;

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
 	var_dump($array);
 	foreach($array as $errorMessage){
 		if(!$errorMessage[0]){
 			$message=$message.$errorMessage[1].'<br>';
 		}

 	}
		return $message;
 }

?>