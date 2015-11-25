<?php
include_once('database/events.php');
//if (isset($_SESSION) && isset($_SESSION['username'])) {
		if(isset($_POST['submit'])) 
		{
			createEvent($_POST);
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
			      Private <input type="checkbox" name="private" value="private" > 
			   </div>

			   <div>
			      <label for="fullText">Text:</label>
			      <textarea   name="fullText" id="fullText" required></textarea>
			   </div>

			   <div>
			      <label for="tagsToSearch">Tags:</label>
			      <textarea   name="tagsToSearch" id="tagsToSearch" required></textarea>
			   </div>

			   <div>
			      <label for="dateTag">Date:</label>
			      <input type="date"  name="dateTag" id="dateTag"required>  
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
			      <button type="submit">Search</button>
			   </div>
			   </fieldset>
			</form>			  

			  <?php
		    // Display the Form and the Submit Button

		   

		   }
		//}
?>