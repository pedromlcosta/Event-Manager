 <?php
 if(empty($searchResults))
    { 
        echo "No events match you search";
    }
  else{     
    foreach($searchResults  as $event)
      {


      $registeredInEvent=0;
        //change it does matter if he is logged in but not in the way I did it
      if($_POST['loggedIn'])
      {
        //might change accordingly if we add an id to user
        $registeredInEvent=checkIfUserResgisteredInEvent($event['event'],$_POST['username']);

      }

      $toPrintEvent=getEvent($event['event'], $registeredInEvent); 
      if($toPrintEvent)
    {  $eventImage=eventGetImage($event['event']);
      ?>
    <!-- should I have this as one page? and then add it or should i leave it as it is?-->
      <div class="event">
        <h3><?=$toPrintEvent['title']?></h3>
        <p><?=$toPrintEvent['fulltext']?></p>

         <img src=<?php  echo $eventImage['image']?> title="evenPick" />   
         <br> 
      <button type="submit">Edit</button>
      </div>
      <br>
      <br>
 <?php
    }
//add button to go back or go back to main page falta ainda ver quando tem sessão iniciada 
    } 
 }?>