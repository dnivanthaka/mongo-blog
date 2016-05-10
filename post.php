<?php
$message = '';
if(isset($_POST['isPosted'])){
  $title   = $_POST['title'];
  $content = $_POST['content'];
  
  try{
    $mongo = new Mongo();
    $database = $mongo->selectDB('phpblog');
    $collection = $database->selectCollection('articles');
    
    $article = array(
      'title' => $title,
      'content' => $content,
      'saved_at' => new MongoDate()
    );
    
    if($collection->insert($article, array('safe'=>True))){
      $message = '<div class="s_err">Article successfully saved.(ID - '.$article['_id'].')</div>';
    }
    
    //print_r($article);
    
  }catch(MongoConnectException $e){
    die('Failed to connect to database '.$e->getMessage());
  }catch(MongoException $e){
    die('Failed to insert data '.$e->getMessage());
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
    <h1>Post a new article</h1>
    <?php echo $message;?>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" class="dataform" method="post">
      <label for="title">Title</label>
      <input type="text" name="title" id="title" />
      <label for="content">Content</label>
      <textarea name="content" id="content"></textarea>
      <input type="hidden" name="isPosted" value="true"/>
      <input type="submit" name="submit" value="Save"/>
    </form>
    </div>
  </div>
  </body>
</html>
