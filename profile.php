<?php
require_once('DBHandling.php');
require_once('Session.php');
require_once('User.php');

$message = '';

  
$user = new User();
  
if(!$user->isLoggedIn()){
    header('Location: index.php');
    exit();
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
    <ul>
      <li><a href="logout.php">Logout</a></li>
    </ul>
    <h1>User Home</h1>
    <?php echo $message;?>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" class="dataform" method="post">
      <label for="username">Username</label>
      <input type="text" name="username" id="username" value="<?php echo $user->username; ?>" />
      <label for="name">Name</label>
      <input type="text" name="name" id="name" value="<?php echo $user->name; ?>" />
      <label for="dob">Date of Birth</label>
      <input type="text" name="dob" id="dob" value="<?php echo date('j F, Y', $user->birthday->sec); ?>" />
      <label for="address">Address</label>
      <textarea name="address" id="address"><?php echo $user->address; ?></textarea>
      <input type="hidden" name="isPosted" value="true"/>
      <input type="submit" class="button_normal" name="submit" value="Save"/>
    </form>
    </div>
  </div>
  </body>
</html>
