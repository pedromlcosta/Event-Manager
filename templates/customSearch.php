      <form action="action_search.php" method="post">
            <div>
             <textarea name="tagsToSearch" id="tagsToSearch" placeholder="Tags"></textarea>
            </div>
            <div>
            <label for="dateTag">Date:</label>
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
     
