<?php
include_once('init.php'); // connects to the database
include_once('database/users.php');
include_once('database/filters.php');
include_once('database/events.php');
include_once('database/tag.php');
include_once('database/tagEvent.php');
include_once('database/usersEvent.php');
    
    
  if (isset($_SESSION['userID']) && isset($_POST['title']) && isset($_POST['fullText']) && isset($_POST['data']) && isset($_POST['Event_Type'])  && isLogged()) {
	$errorMessage = '';
    $eventCreatedId = -1;
    $createOK = false;
    
    if(isset($_POST['private']))
    $privateValue=validateCheckBox($_POST['private']);
    else
    $privateValue=0;

    $dataValid=validateDate($_POST['data']);
    $typeValid=validateTypes($_POST['Event_Type']);
    
    $imageValid=validateImageUpload();
    $errorMessage= getErrorMessage(array($dataValid,$typeValid,$imageValid));
    
    if(strlen($errorMessage)==0){
        $errorMessage = "NO ERRORS";
        global $delimiters;
        global $destEventFolder;
        
        $imageURL=uploadImageFile("images/",'event_create',null);

        
        if (createEvent($_POST['title'], $_POST['fullText'], $privateValue, $_POST['data'], $_SESSION['userID'],$imageURL)) {

            $eventCreatedId = getEventIdByField($_POST['title'],$_POST['data'], $_SESSION['userID']);
            $createOK = true;

            $userId = $_SESSION['userID'];
             
            addEventsTypes($eventCreatedId ,getFilterId($_POST['Event_Type']));
             
            $tags = preg_split("/" . $delimiters . "+/", $_POST["eventTags"]);
         
            foreach ($tags as $tagDesc) {
                
                if($tagDesc!='' && $tagDesc!=' '){
                    $tagId = createTag($tagDesc);
                    if ($eventCreatedId!==false)
                        createTagEvent($eventCreatedId, $tagId);
                }
            }
        }
               
  
    }


    echo json_encode(array($createOK, $errorMessage, $eventCreatedId));
     
}
    
?>