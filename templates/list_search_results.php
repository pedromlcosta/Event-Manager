      <!-- should I have this as one page? and then add it or should i leave it as it is?  ; por isto para imprimir singular events
</script>-->
<?php if(!empty($toPrintEvent)  ){
  
  include_once("genericStart.html");
  ?>
  <script type="text/javascript" src="searchButtons.js"> 
  console.log("Here");
  var userID="<?php echo $_SESSION['userID'];?>";
  var eventID="<?php echo  $event['id'];?>";
  handleSubmits();
  </script>  

  <div class="event">
      <!--  <h3><?=$toPrintEvent['title']?></h3> -->
        <a href=""title="Teste"><?=$toPrintEvent['title']?></a>
        <br>  
             <!--  <img src=<?php  echo $eventImage['image']?> title="evenPicture" />-->
        <p><?=$toPrintEvent['fulltext']?></p>
        <br> 
           <div id="buttons">
        <?php    

      if(isLogged()){
        if(isOwner($_SESSION['userID']) ){ ?>
               <button type="submit" id="editButton">Edit</button>
               <button type="submit" id="deleteButton">Delete</button>
             <?php 
             }
             if(isset($registeredInEvent['attending'])){  
                        if( !$registeredInEvent['attending'] ) {
                           ?>
                                      <button type="submit" id="joinButton">Join</button>
                              <?php      
                           }
                           else{?>
                                      <button type="submit" id="leaveButton">Leave</button>
                              <?php      
                           } 
            }
        }
         ?>
         </div>
        </div>
        <br>
        <br>
<?php  include_once("templates/footer.php"); }
  
?>