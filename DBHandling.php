<?php
class DBHandling
{
  const HOST = 'localhost';
  const PORT = 27017;
  const NAME = 'phpblog';
  
  private $host;
  private $port;
  private $dbname;
  private $connection;
  private $database;
  
  private static $instance;
  
  
  private function __construct($host, $name, $port){
    $this->host = $host;
    $this->dbname = $name;
    $this->port = $port;
    
    $connectionstr = sprintf("mongodb://%s:%d", $this->host, $this->port);
    try{
      $this->connection = new Mongo($connectionstr);
      $this->database = $this->connection->selectDB($this->dbname);
    }catch(MongoConnectException $e){
      throw $e;
    }
  }
  
  public static function getInstance(){
    if(!isset(self::$instance)){
      self::$instance = new DBHandling(DBHandling::HOST, DBHandling::NAME, DBHandling::PORT);
    }
    //var_dump(self::$instance);
    return self::$instance;
  }
  
  public function getCollection($name){
    return $this->database->selectCollection($name);
  }
}