<script type="text/javascript" src="scripts/script.js"></script>
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

        <?php if(!isLogged()){  ?>

        <div id="buttons">
          <button type="button" id="register_button"> REGISTER </button>
          <button type="button" id="login_button"> LOGIN </button>
        </div>

        <div id="register">          
          <form action="action_register.php" method="post" enctype="multipart/form-data">
            <br>
            <input type="text" id="username_register" name="username" placeholder="Username" />
            <input type="password" id="password_register" name="password" placeholder="Password" />
            <input type="text" name="fullname" id="fullname" placeholder="Name" />
            <input type="file" name="fileToUpload" />
            <input type="submit" name="submit" value="Register" />
          </form>
        </div>

        <div id="login">          
          <form action="action_login.php" method="post">
            <br>
            <input type="text" name="username" id="username_login" placeholder="Username" />
            <input type="password" name="password" id="password_login" placeholder="Password" />
            <input type="submit" value="Login"/>
          </form>
        </div>

        <div id="messageStatus">
        </div>

        <?php }else{ 
            //provalvemente mudar de sitio mas && falta sanatizar o input nos mini templates e nos comentários, ask Costa where is code about that
            require_once("ESAPI/src/ESAPI.php");
             require_once("ESAPI/src/reference/DefaultEncoder.php");
             $ESAPI = new ESAPI("ESAPI/test/testresources/ESAPI.xml");
          ?>

        <div id="logout">
          <form action="action_logout.php" method="post">
            <h3 id="hello">
              <?php
              $name =  $ESAPI->getEncoder()->encodeForHTML(getUserFullname($_SESSION['userID']));
              echo "Hi $name ";  
              ?>
            </h3>
            <input type="submit" value="Logout">
          </form>
        </div>

        <div id="userpage_button">
          <form action='user_page.php' method='GET'>
            <input type="hidden" name="userID" value="<?=$_SESSION['userID']?>" >
            <button type="submit"> My Page </button>
          </form>
        </div>

        <div id="createEventForm">
          <form  action="events_create_edit.php" method="post">
            <input type="hidden" name="action" id="action" value="create">

            <div class="button">
              <button type="submit" id="create_event"> Create Events </button>
            </div>
          </form>
        </div>

          <?php } ?>
        </div> <!-- user_fields end div -->
    </div>   <!-- header end div -->      

    <?php if(!isLogged()){ ?>

    <script type="text/javascript">      
    emptyStatus();
    </script>
    <?php } ?>
