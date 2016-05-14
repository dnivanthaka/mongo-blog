<?php
require_once('DBHandling.php');

try{
   //$mongo = new Mongo();
   //$database = $mongo->selectDB('phpblog');
   //$collection = $database->selectCollection('articles');
     $database = DBHandling::getInstance();
     $collection = $database->getCollection('articles');
    
}catch(MongoConnectException $e){
   die('Failed to connect to database '.$e->getMessage());
}
$articlesPerPage = 5;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$skip = ($currentPage - 1) * $articlesPerPage;


$cursor = $collection->find();
$totalArticles = $cursor->count();
$totalPages = (int)ceil($totalArticles / $articlesPerPage);

$cursor->sort(array('saved_at' => -1))->skip($skip)->limit($articlesPerPage);
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
    <div id="navigation">
        <?php if($currentPage > 1){ ?>
        <div class="previous">
        <a href="<?php echo $_SERVER['PHP_SELF'].'?page='.($currentPage - 1); ?>">Newer Posts</a>
        </div>
        <?php } ?>
        <?php if($totalPages > $currentPage) { ?>
        <div class="next">
        <a href="<?php echo $_SERVER['PHP_SELF'].'?page='.($currentPage + 1); ?>">Older Posts</a>
        </div>
        <?php } ?>
    </div>
    <br class="clear"/>
    </div>
  </div>
  </body>
</html>
