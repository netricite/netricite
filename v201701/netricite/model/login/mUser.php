<?php
namespace  Netricite\Model\Login;

use Netricite\Framework as fw;

/**
 * DAL: management of the USER object
 *
 * @author jp
 * @version 2016-13
 *
 */
class mUser extends fw\fwDao {
  
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->table = "user";
    }
    
    /**
     * check user credentials
     *
     * @param string $login userid
     * @param string $pwd password
     * @return boolean true = user existe
     */
    public function login($userid, $pwd){
        $user = $this->get(array("conditions"=> "pseudo = '$userid' AND pwd = '$pwd'"));
        return $user;
    }
    
   /**
    * return user array
    *
    * @param string $key
    * @param string $column (WHERE $column=$key)
    * @return array
    */
   public function getRecord($key,$column="pseudo"){
       return parent::getRecord($key, $column);
   }
   
   // On ne sauvegardera pas le mot de passe en clair dans la base mais plutôt un hash
   //$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
 }