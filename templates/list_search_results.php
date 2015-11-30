      <!-- should I have this as one page? and then add it or should i leave it as it is?  <script type="text/javascript" src="searchButtons.js">  handleSubmits();
</script>-->
<?php if(!empty($toPrintEvent)  ){?>
 
 
          <div class="event">
        <h3><?=$toPrintEvent['title']?></h3>
        <img src=<?php  echo $eventImage['image']?> title="evenPicture" />
        <p><?=$toPrintEvent['fulltext']?></p>
          
        <br> 
        <form action="action_editEvents.php" method="post">
           <div>
              <input type=hidden value=<?php echo $event['id']?> tag="id"  name="id">
           </div>
           <div id="buttons">
        <?php    

      if(isLogged()){
        if(isOwner($_SESSION['userID']) ){ ?>
               <button type="submit" id="editButton">Edit</button>
               <button type="submit" id="deleteButton">Delete</button>
             <?php 
             }  
           if(isset($registeredInEvent['attending']) && !$registeredInEvent['attending'] ) {
              ?>
                         <button type="submit" id="deleteButton">Join</button>
                 <?php      
              } 
        }
         ?>
         </div>
        </form>
        </div>
        <br>
        <br>
<?php }?>