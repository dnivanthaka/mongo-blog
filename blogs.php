<?php
try{
    $mongo = new Mongo();
    $database = $mongo->selectDB('phpblog');
    $collection = $database->selectCollection('articles');
    
}catch(MongoConnectException $e){
   die('Failed to connect to database '.$e->getMessage());
}

$cursor = $collection->find();
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
    <h1>My Blogs</h1>
    <?php
    while($cursor->hasNext()){
      $article = $cursor->getNext();
    ?>
    <div class="blogpost">
      <h3><?php echo $article['title'];?></h3>
      <p><?php echo $article['content'];?></p>
    </div>
    <?php
    }
    ?>
    </div>
  </div>
  </body>
</html>