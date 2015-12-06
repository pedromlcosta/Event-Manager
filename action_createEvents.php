<?php
include_once('genericStart.html');
include_once('init.php'); // connects to the database
include_once('database/users.php');
include_once('database/filters.php');
include_once('database/events.php');
include_once('database/tag.php');
include_once('database/tagEvent.php');
include_once('database/usersEvent.php');


  if (isset($_SESSION['userID']) && isset($_POST['title']) && isset($_POST['fullText']) && isset($_POST['data']) && isset($_POST['Event_Type'])  && isLogged()) {
	$errorMessage = '';

    if(isset($_POST['private']))
    $privateValue=validateCheckBox($_POST['private']);
    else
    $privateValue=0;

    $dataValid=validateDate($_POST['data']);
    $typeValid=validateTypes($_POST['Event_Type']);
  
    $imageValid=validateImageUpload();
    $errorMessage= getErrorMessage(array($dataValid,$typeValid,$imageValid));
    var_dump($_FILES);
    echo "<br>";
    var_dump($_POST);

    if(strlen($errorMessage)==0){
        echo "NO ERRORS<br>";
        global $delimiters;
        global $destEventFolder;
        $imageURL=uploadImageFile($destEventFolder,'event_create',null);

        if (createEvent($_POST['title'], $_POST['fullText'], $privateValue, $_POST['data'], $_SESSION['userID'],$imageURL)) {
            $eventCreatedId = getEventIdByField($_POST['title'],$_POST['data'], $_SESSION['userID']);
           //var _dump($eventCreatedId);
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
  
    }
    else{
        echo $errorMessage;
 
    }
}

?>