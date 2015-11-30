      <!-- should I have this as one page? and then add it or should i leave it as it is?-->
<?php if(!empty($toPrintEvent)){?>
<script type="text/javascript" src="searchButtons.js">
  handleSubmits();
</script>
          <div class="event">
        <h3><?=$toPrintEvent['title']?></h3>
        <p><?=$toPrintEvent['fulltext']?></p>
        <img src=<?php  echo $eventImage['image']?> title="evenPick" />   
        <br> 
        <form action="action_editEvents.php" method="post">
           <div>
              <input type=hidden value=<?php echo $event['id']?> tag="id"  name="id">
           </div>
        <?php    if(isOwner($_SESSION['userID']) && $_POST['loggedIn'] ){ ?>
           <div class="editButton">
           <button type="submit">Edit</button>
           </div>
           <div class="deleteButton">
           <button type="submit">Delete</button>
           </div>
         <?php   }?>
        </form>
        </div>
        <br>
        <br>
<?php }?>