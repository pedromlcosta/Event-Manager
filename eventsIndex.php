	<?php

	  include_once('genericStart.html');
	  include_once('init.php');
	  include_once('database/events.php');
	  include_once('database/image.php');
	  include_once('database/tagEvent.php');
	  include_once('database/tag.php');
	  include_once("database/users.php");

 ?>
 		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<script type="text/javascript" src="events.js"></script>
<?php
		include_once("action_eventHandler.php");
		include('templates/footer.php');
?>