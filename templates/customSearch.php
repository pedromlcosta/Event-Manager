      <form action="action_search.php" method="post">
            <div class="tagSelection">
              <label><h4 class="selTitle">Tags to Search:</h4>
             <textarea name="tagsToSearch" id="tagsToSearch" placeholder="Tags"></textarea></label>
            </div>
            <div class="dateSelection">
            <label for="dateTag"> <h4 class="selTitle">Date:</h4></label>
             <input type="date"  name="dateTag" id="dateTag" >  
            </div>

            <?php 
            $loggedIn=0;
            $username='';  
            if (isLogged()) {
                $loggedIn=1; 
               $username=$_SESSION['userID'];
                 
            } 
            ?>
            <div class="button">
                <button type="submit">Search</button>
            </div>

      </form>
     
