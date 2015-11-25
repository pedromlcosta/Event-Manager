<body>
  <div id="main">
    <div id="header">
      <div id="logo">
        <img src="images/logo.png">
        <p>
      </div>
      <div id="user_fields">
          
          <script type='text/javascript'>
              submitRegisterAJAX();
              submitLoginAJAX();
              emptyStatus();
            </script>

        <?php if(!isset($_SESSION['username'])){ ?>
          <div id="register">
            <form action="action_register.php" method="post" enctype="multipart/form-data">
              REGISTER
              <br>
              <input type="text" name="username" placeholder="Username" />
              <input type="text" name="password" placeholder="Password" />
              <input type="text" name="fullname" placeholder="Name" />
              <input type="file" name="fileToUpload" >
              <input type="submit" name="submit" value="Register" >
              <p>
            </form>
          </div>

          <div id="login">
            <form action="action_login.php" method="post"> LOGIN
              <br>
              <input type="text" name="username" placeholder="Username" />
              <input type="password" name="password" placeholder="Password" />
              <input type="submit" value="Login">
              <p>
            </form>
          </div>
          
          <div id="messageStatus">
          </div>
        <?php }else{ ?>
            <div id="logout">
              <form action="action_logout.php" method="post">
                <h3>
                  <?php 
                    $username = $_SESSION['fullname'];
                    echo "Hi $username ";  
                  ?>
                </h3>
                <input type="submit" value="Logout">
              </form>
            </div>
          <?php } ?>
      </div>
    </div>
  </div>
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
            $username='';  
            if (isset($_SESSION) && isset($_SESSION['username'])) {
                $loggedIn=1; 
               $username=$_SESSION['username'];
                 
            } 
            ?>
            <div>
             <input type=hidden name="username" id="username" value=<?php echo  $username ?>>
              <input type=hidden name="loggedIn" id="loggedIn" value=<?php echo $loggedIn ?> >
             </div>
            <div class="button">
                <button type="submit">Search</button>
            </div>
      </form>
      
  <?php if(isset($_SESSION['username'])){ ?>
    <script type="text/javascript">
    //If logged in, hide login and register tabs
      
      //hideLogin();
     // hideRegister();
     // showLogout();
    </script>
  <?php }else{ ?>
    <script type="text/javascript">
    //If not logged in, hide logout
      //showLogin();
      //showRegister();
      //hideLogout();
      emptyStatus();
    </script>
    <?php } ?>
