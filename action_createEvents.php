<?php
include_once('genericStart.html');
include_once('init.php'); // connects to the database
include_once('database/users.php');
include_once('database/filters.php');
include_once('database/events.php');
include_once('database/tag.php');
include_once('database/tagEvent.php');
include_once('database/usersEvent.php');

 

if (isset($_SESSION['userID']) && isset($_POST['title']) && isset($_POST['fullText']) && isset($_POST['data']) && isset($_POST['Event_Type']) && isLogged()) {
    
	$errorMessage = '';

    if(isset($_POST['private']))
    $privateValue=valiateCheckBox($_POST['private']);
    else
    $privateValue=0;

    $dataValid=validateDate($_POST['data']);
    $typeValid=validateTypes($_POST['Event_Type']);

    
    $errorMessage= getErrorMessage(array($dataValid,$typeValid));
    if(strlen($errorMessage)==0){
        global $delimiters;
        if (createEvent($_POST['title'], $_POST['fullText'], $privateValue, $_POST['data'], $_SESSION['userID'])) {
            $eventCreatedId = getLastEventId();
            var_dump($eventCreatedId);
            $userId         = $_SESSION['userID'];
            //addUserToEvent($eventCreatedId['id'], $userId);
            
            addEventsTypes($eventCreatedId ,getFilterId($_POST['Event_Type']));
    
            $tags = preg_split("/" . $delimiters . "+/", $_POST["eventTags"]);
            print_r($tags);
            foreach ($tags as $tagDesc) {
                print_r($tagDesc);
                if($tagDesc!='' && $tagDesc!=' '){
                    $tagId = createTag($tagDesc);
                    if ($eventCreatedId!==false)
                        createTagEvent($eventCreatedId, $tagId);
                }
            }
        }
    
        $uploadOk = 0;
    
        if(!isset($_FILES["eventImg"])){
            $errorMessage .= "Must select an image. ";
        }else{
    
            if($_FILES["eventImg"]["name"] != ''){
    
                $imageFileType = pathinfo($_FILES["eventImg"]["name"],PATHINFO_EXTENSION);
                $target_file = $target_dir . basename($_POST['username']) . "." . $imageFileType;
        
                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"])) {
                       $check = getimagesize($_FILES["eventImg"]["tmp_name"]);
                       if($check !== false) {
                        //echo "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    }
                }
            }
        }
        if($uploadOk){
        $target_dir = "database/user_images/";
       move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    }
        //TODO falta acrescentar as tretas do path e isso
        /*$image=getImageByPath($_POST['image']);
        if(!$image){
        createImage($_POST['image']);
        $imageId=getLastimageId();
        } 
        else{
        $imageId=$image['id'];
        }
        createImageEvent($eventCreatedId['id'],$imageId);*/
    }
    else{
        echo "ERROR IN EVENT INPUT <br>";
        var_dump($errorMessage);
    }
}

?>