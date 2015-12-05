<?php

	if(!isset($_GET['userID'])){
		// On leaving the page, reset this session variable
		echo "really?";
		header('Location:'. 'index.php');
	}else{
		$_SESSION['currentUserPage'] = $_GET['userID'];
?>

<script src="scripts/users.js"></script>

<script type="text/javascript">
	var userID="<?php echo $_GET['userID'];?>";
	handlers();
</script>

	<div id="content">
		<div id="photo">
			<?php
				$photoURL = getUserImageURL($_GET['userID']);		
			?>
			<img src="<?= $photoURL ?>" alt="Profile Photo" width="200px" height="200px">
		</div>

		<div id="userInfo">
			
		</div>

		<?php
		if(isLogged()){
			if($_SESSION['userID'] == $_GET['userID']){?> 
	 	
		<div id="editFields">

			<div id="errorMessage">
			</div>

			<div id="fullName_change">
				<button type="button" id="fullName_button">Change Full Name </button>
			</div>
						
			<fieldset  id="changeNameForm">
				<legend>Personal Info:</legend>
				<div id="inputFieldOldName">
		 			<input type="text" id="oldUserName">
		 		</div>
		 		<div id="inputFieldNewName">
		 			<input type="text" id="newUserName">
		 		</div>
		 		<button type="submit" id="saveUserNameChanges">Save Changes</button>
			</fieldset>

			<div id="password_change">
				<button type="button" id="password_button">Change Password </button>
			</div>

			<fieldset id="changePassWord">
				<legend>Security:</legend>
		 			<input type="password" id="oldPass"   placeholder="Current password">
		 		
		 			<input type="password" id="newPass"   placeholder="New password">
		 		
		 			<input type="password" id="typeAgainPass"   placeholder="Confirm New password">
		 		
		 		<button type="submit" id="savePasswordChanges">Save Changes</button>
			</fieldset>

		</div> <!-- End editFields div  -->
		<?php
				}
		}?>


		<div id="userEventTabs">
			<ul id="tabs">
				<li><a id="link_userHostedPublic" href="#hostedPublic">User's Upcoming Events ...</a></li>
			</ul>

			<form>
				<div id="hostedPublic" class="tab-section">
					<?php include('filter.php'); ?>
				</div>
			</form>

			<ul id="event_list">
	
			</ul>

			<div id="page_buttons">

			</div>
		</div> <!-- End userEventTabs div  -->			
	</div>	   <!-- End content div  -->
 
<?php } ?>