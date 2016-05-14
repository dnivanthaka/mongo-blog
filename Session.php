<?php
require_once('DBHandling.php');

class Session
{
  const COLLECTION = 'sessions';
  const SESSION_TIMEOUT = 600;
  const SESSION_LIFESPAN = 3600;
  
  const SESSION_NAME = 'mongosessid';
  const SESSION_COOKIE_PATH = '/';
  const SESSION_COOKIE_DOMAIN = '';
  
  private $_mongo;
  private $_collection;
  private $_currentSession;
  
  public function __construct(){
    $this->_mongo = DBHandling::getInstance();
    
    $this->_collection = $this->_mongo->getCollection(Session::COLLECTION);
    session_set_save_handler(
      array(&$this, 'open'),
      array(&$this, 'close'),
      array(&$this, 'read'),
      array(&$this, 'write'),
      array(&$this, 'destroy'),
      array(&$this, 'gc')
    );
    
    ini_set('session.gc_maxlifetime', Session::SESSION_LIFESPAN);
    session_set_cookie_params(Session::SESSION_LIFESPAN, Session::SESSION_COOKIE_PATH, Session::SESSION_COOKIE_DOMAIN);
    session_name(Session::SESSION_NAME);
    session_cache_limiter('nocache');
    
    session_start();
  }
  
  public function __destruct(){
    session_write_close();
  }
  
  public function open($path, $name){
    return true;
  }
  
  public function close(){
    return true;
  }
  
  public function read($sessionId){
    $query = array('session_id' => $sessionId, 'timedout_at' => array('$gte' => time()), 'expired_at' => array('$gte' => time() - Session::SESSION_LIFESPAN));
    
    $result = $this->_collection->findOne($query);
    $this->_currentSession = $result;
    
    if(!isset($result['data'])){
      return '';
    }
    
    return $result['data'];
  }
  
  public function write($sessionId, $data){
    $expired_at = time() + self::SESSION_TIMEOUT;
    
    $new_obj = array(
      'data' => $data,
      'timedout_at' => time() + self::SESSION_TIMEOUT,
      'expired_at'  => (empty($this->_currentSession)) ? time() + Session::SESSION_LIFESPAN : $this->_currentSession['expired_at']
    );
    
    $query = array('session_id' => $sessionId);
    $this->_collection->update($query, array('$set'=>$new_obj), array('upsert'=>True));
    
    return true;
  }
  
  public function destroy($sessionId){
    $this->_collection->remove(array('session_id' => $sessionId));
    
    return true;
  }
  
  public function gc(){
    $query = array('expired_at' => array('$lt' => time()));
    $this->_collection->remove($query);
    return true;
  }
}

$seesion = new Session();