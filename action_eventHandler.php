	<?php
	//include('templates/header.php');

	//print_r($_POST['action']);

/*	if($_POST['action']=="edit"){

	}
	*/
	//	if($_POST['action']=="create"){
			$path="action_createEvents.php";
			$button="Create";
			$title="";
			$fullText="";
			$checked="value";
			$data="";
			$eventTags="";
	//}

 ?>
<form action="<?php echo $path ?>"  method="post">
			 <fieldset>
   				 <legend>Event:</legend>
			   <div>
			      Title <input type="text" name="title" id="title" value="<?php echo $title ?>" required>
			   </div>
			   <div>
			      Private <input type="checkbox" name="private" id="private" checked=""  > 
			   </div>

			   <div>
			      <label for="fullText">Text:</label>
			      <textarea   name="fullText" id="fullText"  value="<?php echo $fullText?>" required></textarea>
			   </div>

			   <div>
			      <label for="eventTags">Tags:</label>
			      <textarea   name="eventTags" id="eventTags"  value="<?php echo $eventTags?>" required></textarea>
			   </div>

			   <div>
			      <label for="data">Date:</label>
			      <input type="date"  name="data" id="data" value="<?php echo $data?>"required>  
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
			      <button type="submit"><?php echo $button?> </button>
			   </div>
			   </fieldset>
			</form>	
<?php
			  	include('templates/footer.php');

			  	?>