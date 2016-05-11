<?php
try{
   $mongo = new Mongo();
   $database = $mongo->selectDB('phpblog');
   $collection = $database->selectCollection('articles');
    
}catch(MongoConnectException $e){
   die('Failed to connect to database '.$e->getMessage());
}
$id = $_GET['id'];
$article = $collection->findOne(array('_id' => new MongoId($id)));
//print_r($article);
//$cursor->sort(array('saved_at' => -1))->skip($skip)->limit($articlesPerPage);
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
    <?php echo $message;?>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" class="dataform" method="post">
      <label for="title">Title</label>
      <p><?php echo $article['title']; ?></p>
      <label for="content">Content</label>
      <p><?php echo $article['content']; ?></p>
    </form>
    </div>
  </div>
  </body>
</html>
