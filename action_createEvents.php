<?php
include_once('database/connection.php');
include_once('database/events.php');
include_once('database/tag.php');
include_once('database/tagEvent.php');
include_once('database/users.php');
include_once('database/usersEvent.php');

//if (isset($_SESSION) && isset($_SESSION['username'])) {
		if(isset($_POST['submit'])) 
		{
			//print_r($_POST);
			$privateValue;
			if(!isset($_POST['private']))
				$privateValue=0;
			else
				$privateValue=parseCheckBox($_POST['private']);
			
			//$_SESSION['username']
			  $delimiters="[\s,\/,\|]";
			if(createEvent($_POST['title'],$_POST['fullText'],$privateValue,$_POST['data'] ,"Filipe")) {
						 $eventCreatedId=getLastEventId();
						 //$_SESSION['username']
						 $userId=getUserId("Filipe");
						 addUserToEvent($eventCreatedId['id'], $userId);
						  $tags=preg_split( "/".$delimiters."+/",$_POST["eventTags"] ); 
						  foreach ($tags as $tagDesc) {
						  	//print_r($tagDesc);
						  	//print_r($eventCreatedId );
						   	$tagId=createTag($tagDesc);
						   	if($eventCreatedId)
						  	createTagEvent($eventCreatedId['id'],$tagId);

						}
			  } 
		}
		else               
		{
			?>
			<form action="action_createEvents.php" method="post">
			 <fieldset>
   				 <legend>Event:</legend>
			   <div>
			      Title <input type="text" name="title" id="title" required/>
			   </div>
			   <div>
			      Private <input type="checkbox" name="private" id="private"  > 
			   </div>

			   <div>
			      <label for="fullText">Text:</label>
			      <textarea   name="fullText" id="fullText" required></textarea>
			   </div>

			   <div>
			      <label for="eventTags">Tags:</label>
			      <textarea   name="eventTags" id="eventTags" required></textarea>
			   </div>

			   <div>
			      <label for="data">Date:</label>
			      <input type="date"  name="data" id="data"required>  
			   </div>
				<br>
			   <div>
			      <input type="file" name="eventImg" id="eventImg"required>
			   </div>
				
				<div>
			   		<input type=hidden  name="submit" id="submit" value='1'> 
				</div>
				<br>
			   <div class="button">
			      <button type="submit">Create</button>
			   </div>
			   </fieldset>
			</form>			  

			  <?php
		   }
		//}

		   function parseCheckBox($value){
		   	if($value=='on')
		   		return 1;
		   	else 
		   		return 0;

		   }
?>