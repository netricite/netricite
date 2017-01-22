<?php
namespace  Netricite\Model\Blog;

use Netricite\Framework as fw;

/**
 * DAL: management of the blogcomment object
 *
 * @author jp
 * @version 2016-14
 *
 */
 class mPost extends fw\fwDao {
     /**
      * constructor
      */
     public function __construct()
     {
         appTrace(debug_backtrace());
         $this->table = "blogpost";
     }
     
  /*
   * get all the posts attached to one blog
   * 
   * @param INT $id
   * @throws fw\fwException
   */ 
  public function getRecords($id) {
    $conditions = "blogid='$id'";
    return $this->get(array("conditions" => $conditions));
  }
	
}