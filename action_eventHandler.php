	<?php
	  include_once('init.php');
 	  include('templates/header.php');
	  include_once('database/events.php');
	  include_once('database/image.php');
	  include_once('database/tagEvent.php');
	  include_once('database/tag.php');
	  
if(isset($_POST['action'])){

		 
	 	if ($_POST['action'] == "edit") {
			$path = "action_editEvents.php";
			$button = "Edit";
			$eventID =  $_POST['id'];
			$required="";
			$event = getEventByID($eventID);
			$title = $event['title'];
			$fullText = $event['fulltext'];
			$data = $event['data'];
			$eventTags = "";
			$tagIDs = getTagWithEvent($eventID);
		 
			$sizeOfArray=count($tagIDs);
			for($i=0;$i<$sizeOfArray;$i++) {
				$tagId=$tagIDs[$i];
				
				if($i<$sizeOfArray-1)
					$eventTags = $eventTags.getTagDesc($tagId['tag_id']). " ";
				else
					$eventTags = $eventTags.getTagDesc($tagId['tag_id']);
			}
		 
 	}

	 	if ($_POST['action'] == "create") {
			 $path = "action_createEvents.php";
			$button = "Create";
			$title = "";
			$fullText = "";
			$data = "";
			$eventTags = "";
			$required="required";
			$eventID = ""; 
	 	}


 ?>
<form action="<?php echo $path ?>"  method="post">
			 <fieldset>
   				 <legend>Event:</legend>
			   <div>
			      Title <input type="text" name="title" id="title" value="<?php echo $title ?>" required>
			   </div>
			   <div>
			      Private <input type="checkbox" name="private" id="private"   > 
			   </div>

			   <div>
			      <label for="fullText">Text:</label>
			      <textarea   name="fullText" id="fullText"   required><?php echo $fullText?></textarea>
			   </div>

			   <div>
			      <label for="eventTags">Tags:</label>
			      <textarea   name="eventTags" id="eventTags" required><?php echo $eventTags?></textarea>
			   </div>

			   <div>
			      <label for="data">Date:</label>
			      <input type="date"  name="data" id="data" value="<?php echo $data?>"required>  
			   </div>
				<br>
			   <div>
			      <input type="file" name="eventImg" id="eventImg" <?php echo $required?> >
			   </div>
				
				<div>
				<input type=hidden  name="eventID" id="eventID" value="<?php echo $eventID?>"> 
				</div>
				<br>
			   <div class="button">
			      <button type="submit"><?php echo $button?> </button>
			   </div>
			   </fieldset>
			</form>	
<?php
			  	include('templates/footer.php');
}
			  	?>