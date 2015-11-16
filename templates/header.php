<!DOCTYPE html>
<html> 
  <head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>CSS Exercise</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <style type="text/css"></style></head>
    <body>

    

    <div id="header">
      <h1>Online Newspaper</h1>
      <h2>CSS Exercise</h2>
    </div>

    <?php if (!isset($_SESSION['user'])){ ?>
    <div id="login">
      <form action="action_login.php" method="post">
        <input type="text" name="login">
        <input type="password" name="password">
        <input type="submit" value="login">
      </form>
   

    <?php  if(isset($_SESSION['failedLogin'])){
            echo "Username/Password combination failed.";
            unset($_SESSION['failedLogin']);
          }
      }else{ ?>
    </div>

    <div id="logout">
    <form action="action_logout.php" method="post">
    <?php echo "Hello ". $_SESSION['user']; ?>
    <input type="submit" value="logout">
    </form>
    </div>
    <?php } ?>

    <div id="menu">
      <ul>
        <li><a href="">Politics</a></li>
        <li><a href="">Sports</a></li>
        <li><a href="">World</a></li>
        <li><a href="">Education</a></li>
        <li><a href="">Society</a></li>
      </ul>
    </div>
    <div id="content">