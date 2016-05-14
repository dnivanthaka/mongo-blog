<?php
require_once('DBHandling.php');
require_once('Session.php');

class User{
  const COLLECTION = 'users';
  private $_mongo;
  private $_collection;
  private $_user;
  
  public function __construct(){
    $this->_mongo = DBHandling::getInstance();
    $this->_collection = $this->_mongo->getCollection(User::COLLECTION);
    if($this->isLoggedIn())
      $this->_loadData();
  }
  
  public function isLoggedIn(){
    return isset($_SESSION['user_id']);
  }
  
  public function authenticate($username, $password){
    $query = array(
      'username' => $username,
      'password' => md5($password)
    );
    
    $this->_user = $this->_collection->findOne($query);
    if(empty($this->_user)) return false;
    
    $_SESSION['user_id'] = (string)$this->_user['_id'];
    return true;
  }
  
  public function logout(){
    unset($_SESSION['user_id']);
  }
  
  public function __get($attr){
    if(empty($this->_user)) return null;
    
    switch($attr){
      case 'address':
	$address = $this->_user['address'];
	return sprintf('Town: %s, Planet: %s', $address['town'], $address['planet']);
	
      case 'town':
	return $this->_user['address']['town'];
      case 'planet':
	return $this->_user['address']['planet'];
	
      case 'password':
	return null;
      default:
	return (isset($this->_user[$attr])) ? $this->_user[$attr] : null;
    }
  }
  
  private function _loadData(){
    $id = new MongoId($_SESSION['user_id']);
    
    $this->_user = $this->_collection->findOne(array('_id'=>$id));
  }
}