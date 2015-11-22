 <?php
  include_once('database/connection.php');
  include_once('database/tag.php');
  include_once('database/tagEvent.php');
  include_once('database/events.php');

  $delimiters="[\s,\/|]";
  $searchResults= array();
  $tags=preg_split( "/".$delimiters."+/",$_POST["tagsToSearch"] ); 

  if(!empty($_POST['dateTag'])){
    array_push($tags, $_POST['dateTag']);
}
 
 foreach( $tags as $toSearch){

  $tempTag=getTag($toSearch);

    if($tempTag){

        $eventsWithTempTag=getEventWithTag($tempTag['id']);

        if(empty($searchResults)){
          $searchResults=$eventsWithTempTag;
      }
    else{  
        $searchResults=  array_uintersect($searchResults, $eventsWithTempTag,'compareEvents');
      }
    }
 }
    if(empty($searchResults))
    { 
        echo "No events match you search";
    }
  else{     
    foreach($searchResults  as $event)
      {
      $toPrintEvent=getEvent($event['event'],$_POST['loggedIn']); 
      if($toPrintEvent)
    {  $eventImage=eventGetImage($event['event']);
      ?>
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
 }
     function compareEvents($tagEvent,$tagEvent1){
      return ($tagEvent['event']==$tagEvent1['event']);
 }
?>
 