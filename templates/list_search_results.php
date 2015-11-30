 <?php
 if(empty($searchResults)){ 
        echo "No events match you search";
    }
  else{     
    foreach($searchResults  as $event){

      $registeredInEvent=0;
      print_r($_POST);
        //change it does matter if he is logged in but not in the way I did it
      if($_POST['loggedIn']){
        //might change accordingly if we add an id to user
        $registeredInEvent=checkIfUserResgisteredInEvent($event['id'],$_POST['username']);
        print_r($registeredInEvent);

      }

      $toPrintEvent=getEvent($event['id'], $registeredInEvent); 
      if($toPrintEvent){  

      $eventImage=eventGetImage($event['id']);
      
 
    
  ?>
      <!-- should I have this as one page? and then add it or should i leave it as it is?-->

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
         <?php   }?>
        </form>
        </div>
        <br>
        <br>
 <?php
  }
//add button to go back or go back to main page falta ainda ver quando tem sessão iniciada 
    } 
 }?>