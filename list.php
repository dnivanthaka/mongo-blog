<?php
try{
   $mongo = new Mongo();
   $database = $mongo->selectDB('phpblog');
   $collection = $database->selectCollection('articles');
    
}catch(MongoConnectException $e){
   die('Failed to connect to database '.$e->getMessage());
}

$cursor = $collection->find();
$count = $cursor->count();

//$cursor->sort(array('saved_at' => -1))->skip($skip)->limit($articlesPerPage);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Blog</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <link rel="stylesheet" href="styles.css" media="screen" />
    <script type="text/javascript">
      function gotoURL(url){
	window.document.location = url;
      }
    </script>
  </head>
  
  <body>
  <div id="pageContainer">
    <div id="pageBody">
    <h1>Manage My Blogs</h1>
    <table class="datagrid" cellpadding="0" cellspacing="0">
      <thead>
	    <tr>
	    <th>Title</th>
	    <th width="200px">Posted On</th>
	    <th width="200px">Actions</th>
	    </tr>
      </thead>
      <tbody>
      <?php
      if($count > 0){
      while($cursor->hasNext()){
      $article = $cursor->getNext();
      ?>
      <tr>
	<td><?php echo $article['title'];?></td>
	<td><?php echo date('g:i a, F j',$article['saved_at']->sec);?></td>
	<td>
	<input type="button" class="button_normal" name="submit" onclick="gotoURL('blog.php?id=<?php echo $article['_id']; ?>')" value="View"/>
	<input type="button" class="button_normal" name="submit" onclick="gotoURL('')" value="Edit"/>
	<input type="button" class="button_danger" name="submit" onclick="gotoURL('')" value="Delete"/>
	</td>
      </tr>
      <?php
      }
      }else{
      ?>
      <tr>
	<td colspan="3">No records found</td>
      </tr>
      <?php
      }
      ?>
      </tbody>
    </table>
    </div>
  </div>
  </body>
</html>
