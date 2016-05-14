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
    <h1>User Home</h1>
    <?php echo $message;?>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" class="dataform" method="post">
      <label for="title">Title</label>
      <input type="text" name="title" id="title" />
      <label for="content">Content</label>
      <textarea name="content" id="content"></textarea>
      <input type="hidden" name="isPosted" value="true"/>
      <input type="submit" class="button_normal" name="submit" value="Save"/>
    </form>
    </div>
  </div>
  </body>
</html>
