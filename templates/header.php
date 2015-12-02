<script type="text/javascript" src="script.js"></script>
<body>
  <div id="main">
    <div id="header">
      <div id="logo">
        <a href="index.php"> <img src="images/logo.png" alt="Logo" width="250" height="150"> </a>
      </div>
      <div id="user_fields">

        <script type='text/javascript'>
        onReadyAddHandlers();
        </script>

        <?php if(!isLogged()){ ?>

        <div id="buttons">
          <button type="button" id="register_button"> REGISTER </button>
          <button type="button" id="login_button"> LOGIN </button>
        </div>

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
            <h3 id="hello">
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
        <div id="createEventForm">
          <form  action="action_eventHandler.php" method="post">
            <input type="hidden" name="action" id="action" value="create">

            <div class="button">
              <button type="submit" id="create_event"> Create Events </button>
            </div>
          </form>
          <?php } ?>
        </div> <!-- user_fields end div -->



      </div>
    </div>   <!-- header end div -->      

    <?php if(!isLogged()){ ?>

    <script type="text/javascript">      
    emptyStatus();
    </script>
    <?php } ?>
