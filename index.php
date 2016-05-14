<?php
require_once('DBHandling.php');
require_once('Session.php');
require_once('User.php');

$message = '';

if(isset($_POST['isPosted'])){
  $username = $_POST['username'];
  $password = $_POST['password'];
  
  $user = new User();
  
  if($user->authenticate($username, $password)){
    header('Location: home.php');
    exit();
  }else{
    $message = 'Username/Password didnot match.';
  }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Blog</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <link rel="stylesheet" href="styles.css" media="screen" />
    <style></style>
  </head>
  
  <body>
  <div id="pageContainer">
    <div id="pageBody">
    <h1>Login</h1>
    <?php echo $message;?>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" class="dataform" method="post">
      <label for="username">Username</label>
      <input type="text" name="username"/>
      <label for="password">Password</label>
      <input type="text" name="password"/>
      <input type="hidden" name="isPosted" value="true"/>
      <input type="submit" class="button_normal" name="submit" value="Submit"/>
    </form>
    </div>
  </div>
  </body>
</html>