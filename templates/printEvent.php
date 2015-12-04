
<?php
print_r($_GET);
  // check path, for the love of god all of this paths are brokend 
  //include_once($_SERVER['DOCUMENT_ROOT'] .'/Event-Manager/templates/genericStart.html');
//TODO check private
  include_once($_SERVER['DOCUMENT_ROOT'] .'/Event-Manager/init.php');
  include_once($_SERVER['DOCUMENT_ROOT'] .'/Event-Manager/database/events.php');
  include_once($_SERVER['DOCUMENT_ROOT'] .'/Event-Manager/database/usersEvent.php');
   $remove=false;
  ?>
<script src="../searchButtons.js"></script>
<script src="../jquery-1.10.2.js"></script>
 

  <div class="event">
    <form id="form" action="../action_eventHandler.php" method="post">
   <input type=hidden id="action" name="action" value="edit"/>
    <input type=hidden id="id" name="id" value="<?php echo $_GET['eventID'];?>"/>
   <button type="submit" id="editButton">Edit</button>
   <button type="submit" id="deleteButton">Delete</button>
   <button type="submit" id="inviteButton">Invite</button>
   <button type="submit" id="joinButton">Going</button>
   <button type="submit" id="leaveButton">Not Going</button>
   <button type="submit" id="removeButton">Remove From Event</button> 
 
  
 
   </form>
      <!--  <h3><?=$toPrintEvent['title']?></h3> -->
        <!--  <a href=""title="Teste"><?=$toPrintEvent['title']?></a>-->
        <br>  
             <!--  <img src=<?php  echo $eventImage['image']?> title="evenPicture" />-->
        <!--  <p><?=$toPrintEvent['fulltext']?></p> -->
        <br> 
        <?php    
      if(isLogged()){
        if(isOwner($_SESSION['userID'],$_GET['eventID']) ){ ?>
          <script  type="text/javascript">   
              var userID=parseInt("<?php echo $_SESSION['userID'];?>",10);
              var eventID=parseInt("<?php echo $_GET['eventID'];?>",10);
              handleSubmits();
          </script>  
        <div id="buttons">
              <script type="text/javascript">
              showOwnerButtons();
              </script>
             <?php 
             }
                    if( isInvited($_GET['eventID'],$_SESSION['userID'])){ 
                        ?>
                       <script type="text/javascript">
                       console.log("Add Join");
                        showJoinButton();
                        </script>
                        <?php
                         $remove=true;
                    }
                    else
                       if( isAttending($_GET['eventID'],$_SESSION['userID']) ) {
                        ?> 
                           <script type="text/javascript">
                           console.log("Add Leave");
                           showLeaveButton();

                           </script>
                       <?php 
                        $remove=true;     
                       }
                       if( $remove){
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
        <br>
<?php  
include_once("../templates/footer.php"); 
}
?>