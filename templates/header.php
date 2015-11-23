<body>
  <div id="main">
    <div id="header">
 
      <div id="logo">
       <img src="images/logo.png">
        <p>
      </div>
    
    <?php if(!isset($_SESSION['username'])){ ?>
      <div id="register">
        <form action="action_register.php" method="post" enctype="multipart/form-data"> 
        REGISTER
          <br>
          <input type="text" name="username" value="username" />
          <input type="text" name="password" value="password" />
          <input type="text" name="fullname" value="name"/>
          <input type="file" name="fileToUpload" id="fileToUpload">
          <input type="submit" name="submit" value="Register">
          <p>
        </form>
      </div>
      <div id="login">
        <form action="action_login.php" method="post"> LOGIN
          <br>
          <input type="text" name="username" value="username" />
          <input type="password" name="password" value="password" />
          <input type="submit" value="Login">
          <p>
        </form>
        <?php  if(isset($_SESSION['loginFailed'])){
            echo "Username/Password combination failed.";
            unset($_SESSION['loginFailed']);
          }

          if(isset($_SESSION['registerStatus'])){
            echo $_SESSION['registerStatus'];
            unset($_SESSION['registerStatus']);
          }

           if(isset($_SESSION['registerUpload'])){
            echo " ". $_SESSION['registerUpload'];
            unset($_SESSION['registerUpload']);
          }
      }else{ ?>
      </div>
      <div id="logout">
        <form action="action_logout.php" method="post">
          <p3>
            <?php 
                $username = $_SESSION['fullname'];
             	echo "Hi $username "  
             	?>
          </p3>
          <input type="submit" value="Logout">
        </form>
      </div>
      <?php } ?>
      <form action="action_search.php" method="post">
            <div>
            <label for="tagsToSearch">Tags:</label>
                <textarea   name="tagsToSearch" id="tagsToSearch" /></textarea>
            </div>
            
            <div>
            <label for="dateTag">Date:</label>
             <input type="date"  name="dateTag" id="dateTag">  
            </div>

            <?php 
            $loggedIn=0;
            if (isset($_SESSION) && isset($_SESSION['username'])) {
                $loggedIn=1;?>
                <input type=hidden name="userName" id="userName" value=<?php echo $_SESSION['username'] ?>>
                <?php 
            }
            ?>
            <div>
              <input type=hidden name="loggedIn" id="loggedIn" value=<?php echo $loggedIn ?> >
             </div>
            <div class="button">
                <button type="submit">Search</button>
            </div>
      </form>

      </div>
        <div id="content">
        </div>
  </div>

