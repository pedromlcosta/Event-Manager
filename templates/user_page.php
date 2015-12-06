<?php

	if(!isset($_GET['userID'])){
		//echo "really?";
		header('Location:'. 'index.php');
	}else{
		$_SESSION['currentUserPage'] = $_GET['userID'];

  $ESAPI = new ESAPI("ESAPI/test/testresources/ESAPI.xml");
   
?>

<script src="scripts/users.js"></script>

<script type="text/javascript">
	var userID="<?php echo $_GET['userID'];?>";
	handlers();
</script>

	<div id="content">
		<div id="userInfo">
		<div id="photo">
			<?php
				$photoURL = $ESAPI->getEncoder()->encodeForHTML(getUserImageURL($_GET['userID']));		
			?>
			<img src="<?= $photoURL ?>" alt="Profile Photo" width="200px" height="200px">
		</div>

		<div id="user_fullname">
			<h1><?= $ESAPI->getEncoder()->encodeForHTML(getUserFullname($_GET['userID'])) ?> </h1>
		</div>
		</div> <!-- End userInfo div -->
		<?php
		if(isLogged()){
			if($_SESSION['userID'] == $_GET['userID']){?> 
	 	
		<div id="editFields">

			<div id="errorMessage">
			</div>

			<div id="userImage_change">
				<button type="button" id="image_button">Change Image </button>
				<form action="action_buttons.php" method="post" enctype="multipart/form-data">
				<fieldset  id="changeImageForm">
					<legend>Image</legend>
					 <input type="hidden" name="action" value="CHANGE_USER_IMAGE" />
		 			 <input type="file" id="userImageUpload" name="fileToUpload" />
		 			<button type="submit" id="saveImageChanges">Save Image</button>
				</fieldset>
				</form>
			</div>

			<div id="fullName_change">
				<button type="button" id="fullName_button">Change Full Name </button>
									
				<fieldset  id="changeNameForm">
					<legend>Personal Info</legend>
		 			<input type="password" id="currentPassword" placeholder="Current Password">
		 		
		 			<input type="text" id="newUserName" placeholder="New Full Name">
		 		
		 			<button type="submit" id="saveUserNameChanges">Save Name</button>
				</fieldset>
			</div>

			<div id="password_change">
				<button type="button" id="password_button">Change Password </button>
			
			<fieldset id="changePassWord" name="">
				<legend>Security</legend>
		 			<input type="password" id="oldPass"   placeholder="Current password">
		 		
		 			<input type="password" id="newPass"   placeholder="New password">
		 		
		 			<input type="password" id="typeAgainPass"   placeholder="Confirm New password">
		 		
		 		<button type="submit" id="savePasswordChanges">Save Password</button>
			</fieldset>
			</div>

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