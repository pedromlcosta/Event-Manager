<?php
  
function getEventWithTag($id)
{
   global $db;
   $stmt = $db->prepare('SELECT  event FROM tagEvent WHERE tag= :id');
   $stmt->bindValue(':id', $id);
   $stmt->execute();  
   return $stmt->fetchAll();
} 
function getEventsWithAnd($tags){
   global $db;
   $queryPart='SELECT DISTINCT id FROM events WHERE id NOT IN (SELECT events.id as event1 FROM events,tag WHERE tag.id IN (';
   $queryPart2=') AND NOT ( tag.id IN    (SELECT tag FROM tagEvent WHERE event=event1)))';

         $queryPart1='';
         for($i=0;$i<count($tags);$i++){

               if($i==0)
                  $queryPart1=$queryPart1.'?';
             else
                  $queryPart1=$queryPart1.',?';
   }
   $query=$queryPart.$queryPart1.$queryPart2;
  
   $stmt = $db->prepare($query);
   $stmt->execute($tags);  
   return $stmt->fetchAll();
}

function getEventsWithOr($tags){
    global $db;
   $queryPart='SELECT id FROM events WHERE id IN (SELECT DISTINCT event FROM tagEvent WHERE tag IN (';
   $queryPart1='';
        
         for($i=0;$i<count($tags);$i++){

               if($i==0)
                  $queryPart1=$queryPart1.'?';
             else
                  $queryPart1=$queryPart1.',?';

         }

   $query=$queryPart.$queryPart1.'))';
  
   $stmt = $db->prepare($query);
   $stmt->execute($tags);  
   return $stmt->fetchAll();

}

function getTagWithEvent($id)
{
   global $db;
   $stmt = $db->prepare('SELECT * FROM tagEvent WHERE event= :id');
   $stmt->bindValue(':id', $id);
   $stmt->execute();  
   return $stmt->fetchAll();
}
 
  ?>