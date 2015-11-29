<body>
  <div id="main">
    <div id="header">
      <div id="logo">
        <a href="index.php"> <img src="images/logo.png" alt="Logo"> </a>
      </div>
      <div id="user_fields">
          
          <script type='text/javascript'>
              onReadyAddHandlers();
            </script>

        <?php if(!isLogged()){ ?>

          <button type="button" id="register_button"> REGISTER </button>
          <button type="button" id="login_button"> LOGIN </button>
          <div id="register">          
            <form action="action_register.php" method="post" enctype="multipart/form-data">
              <br>
              <input type="text" id="username" name="username" placeholder="Username" />
              <input type="password" id="password" name="password" placeholder="Password" />
              <input type="text" name="fullname" id="fullname" placeholder="Name" />
              <input type="file" name="fileToUpload" />
              <input type="submit" name="submit" value="Register" />
            </form>
          </div>

          <div id="login">          
            <form action="action_login.php" method="post">
              <br>
              <input type="text" name="username" id="username" placeholder="Username" />
              <input type="password" name="password" id="password" placeholder="Password" />
              <input type="submit" value="Login"/>
            </form>
          </div>
          
          <div id="messageStatus">
          </div>

        <?php }else{ ?>

            <div id="logout">
              <form action="action_logout.php" method="post">
                <h3>
                  <?php
                    $name = getUserFullname($_SESSION['userID']);
                    echo "Hi $name ";  
                  ?>
                </h3>
                <input type="submit" value="Logout">
              </form>
            </div>

            <div id="userpage_button">
              <form action='user_page.php' method='GET'>
                <input type="text" name="userID" value="<?=$_SESSION['userID']?>" hidden>
                <button type="submit"> My Page </button>
              </form>
            </div>

          <?php } ?>
      </div> <!-- user_fields end div -->
      <div id="search">
      <form action="action_search.php" method="post">
            <div>
                <textarea name="tagsToSearch" id="tagsToSearch" placeholder="Tags">
                </textarea>
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
            <div>
             <input type="hidden" name="username" id="username" value="<?php echo $username ?>">
              <input type="hidden" name="loggedIn" id="loggedIn" value="<?php echo $loggedIn ?>">
             </div>
            <div class="button">
                <button type="submit">Search</button>
            </div>
      </form>
      </div> <!-- search end div -->
    </div>   <!-- header end div -->      
      
  <?php if(!isLogged()){ ?>

    <script type="text/javascript">      
      emptyStatus();
    </script>
    <?php } ?>
