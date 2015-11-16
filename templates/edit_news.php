<?php
if(!isset($_SESSION['user'])){
	header('Location:' . "list_news.php");
}
?>


<form action= "action_edit_news.php" method="post">
	
	<input type="hidden" name="id" value="<?=$newsID ?>">

	<!-- TITLE -->
	<p></p>
	<label>Title:
	<p></p>
	<input type="text" name="title" value="<?=$newsItem['title']?>"> 
	<label>

	<!-- INTRODUCTION -->
	<p> </p>
	<label>Introduction:
	<p></p>
	<textarea name="introduction" rows="10" cols="100"> <?php echo $newsItem['introduction']?>	</textarea>
	</label>

	<!-- TEXT -->
	<p></p>
	<label>Full Text:
	<p></p>
	<textarea name="fulltext" rows="10" cols="100"> <?php echo $newsItem['fulltext']?>	</textarea>
	</label>

	<!-- SUBMIT -->
	<p></p>
	<input type="submit" value="Done">
</form>