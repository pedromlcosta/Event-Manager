<?php
print_r($_GET);

//TODO check private
 if(isset($_GET['eventID'])  && !empty($_GET['eventID'] )) {
  $remove=false;
  $hasPermission=false;
  $isLogged=false;
  $isOwner=false;
  $isInvited=false;
  $isAttending=false;
  $isPublic=false;
 if(isPublic($_GET['eventID'])){
      $hasPermission=true;
      $isPublic=true;

    }
 if(isLogged()) {
      $isLogged=true;
     
  if(isOwner($_SESSION['userID'],$_GET['eventID']) ){
      $isOwner=true;
       $hasPermission=true;
     }
  if( isInvited($_GET['eventID'],$_SESSION['userID'])) {
        $isInvited=true;
        $hasPermission=true;
      }
  else 
     if( isAttending($_GET['eventID'],$_SESSION['userID']) ) {
          $isAttending=true;
          $hasPermission=true;

       }

  }     
         if($hasPermission){
      $event=getEventInfo($_GET['eventID']);
     ?>
       <h3><?=$event['title']?> </h3>
     <img src=<?php  echo $event['url']?> title="evenPicture" /> 
    <p> <?=$event['fulltext']?> </p>
    <p><?=$event['data']?> </p>
    <p> <?=getUserFullname($event['user_id']);?> </p>
    <?php
   
}
else
{
  //does not have permission 
}
  ?>


        <div class="event">
            <form id="form" action="eventsIndex.php" method="post">
                <input type=hidden id="action" name="action" value="edit" />
                <input type=hidden id="id" name="id" value="<?php echo $_GET['eventID'];?>" />
                <button type="submit" id="editButton">Edit</button>
                <button type="submit" id="deleteButton">Delete</button>
                <button type="submit" id="inviteButton">Invite</button>
                <button type="submit" id="joinButton">Going</button>
                <button type="submit" id="leaveButton">Not Going</button>
                <button type="submit" id="removeButton">Remove From Event</button>
             
            </form>

            <br>
            <script type="text/javascript">
            handleSubmits();
            </script>
            <?php    
      if($isLogged){
        if($isOwner){
       ?>
                <script type="text/javascript">
                var userID = parseInt("<?php echo $_SESSION['userID'];?>", 10);
                var eventID = parseInt("<?php echo $_GET['eventID'];?>", 10);
                </script>
                <div id="buttons">
                    <script type="text/javascript">
                    showOwnerButtons();
                    </script>
                    <?php 
             }
                    if( $isInvited  || $isPublic ){ 
                        ?>
                        <script type="text/javascript">
                        console.log("Add Join");
                        showJoinButton();
                        </script>
                        <?php
                         $remove=true;
                    }
                    else
                       if( $isAttending  ) {
                        ?>
                            <script type="text/javascript">
                            console.log("Add Leave");
                            showLeaveButton();
                            </script>
                            <?php 
                        $remove=true;     
                       }

                       if($remove){
                          ?>
                                <script type="text/javascript">
                                showRemoveButton();
                                </script>
                                <?php
                       }
         ?>
                </div>
        </div>
        <br>
        <?php  
          if($isOwner || $isAttending){
      ?>
         <br>
                 <textarea id="commentTextArea" placeholder="Comment"></textarea>
                 <br>
                 <button type="submit" id="addCommentButton">Add Comment</button>
      <?php
    }

 }
  }
      

?>