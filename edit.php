<?php
require_once('DBHandling.php');

$message = '';
$id = $_GET['id'];
  
  try{
    //$mongo = new Mongo();
    //$database = $mongo->selectDB('phpblog');
    //$collection = $database->selectCollection('articles');
    $database = DBHandling::getInstance();
    $collection = $database->getCollection('articles');
    
    if(isset($_POST['isPosted'])){
      $title   = $_POST['title'];
      $content = $_POST['content'];

      $article = array(
	'title' => $title,
	'content' => $content,
	'saved_at' => new MongoDate()
      );
      
      if($collection->update(array('_id'=> new MongoId($id)), $article)){
	$message = '<div class="s_ok">Article successfully updated.(ID - '.$id.')</div>';
      }
    }
    
    
    $article = $collection->findOne(array('_id' => new MongoId($id)));
    //print_r($article);
    
  }catch(MongoConnectException $e){
    die('Failed to connect to database '.$e->getMessage());
  }catch(MongoException $e){
    die('Failed to insert data '.$e->getMessage());
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
    <form action="<?php echo $_SERVER['PHP_SELF'];?>?id=<?php echo $id; ?>" class="dataform" method="post">
      <label for="title">Title</label>
      <input type="text" name="title" id="title" value="<?php echo $article['title'];?>" />
      <label for="content">Content</label>
      <textarea name="content" id="content"><?php echo $article['content'];?></textarea>
      <input type="hidden" name="isPosted" value="true"/>
      <input type="submit" class="button_normal" name="submit" value="Save"/>
    </form>
    </div>
  </div>
  </body>
</html>
