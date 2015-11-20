<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>Event Manager</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style.css">
  <style type="text/css"></style>
</head>

<body>
  <div id="main">
    <div id="header">
      <div id="logo">
        LOGO EXAMPLE HERE
        <p>
      </div>
    </div>
    <?php if(!isset($_SESSION['username'])){ ?>
      <div id="login">
        <form action="action_login.php" method="post">
          <input type="text" name="username" />
          <input type="password" name="password" />
          <input type="submit" value="login">
          <p>
        </form>

        <?php  if(isset($_SESSION['loginFailed'])){
            echo "Username/Password combination failed.";
            unset($_SESSION['loginFailed']);
          }
      }else{ ?>
      </div>
        <div id="logout">
          <form action="action_logout.php" method="post">
            <p3>
              <?php $username = $_SESSION['username'];
              echo "Hi $username "  ?>
            </p3>
            <input type="submit" value="Logout">
          </form>
        </div>
        <?php } ?>
          <div id="content">
          </div>
  </div>
  
