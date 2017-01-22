<?php
namespace  Netricite\Model\Blog;

use Netricite\Framework as fw;

/**
 * DAL: management of the blogcomment object
 *
 * @author jp
 * @version 2016-13
 *
 */
 class mComment extends fw\fwDao {
     /**
      * constructor
      */
     public function __construct()
     {
         appTrace(debug_backtrace());
         $this->table = "blogcomment";
     }
 
  /**
   * get all the comments attached to one post
   * 
   * @param int $id
   * @return \Netricite\Framework\PDOStatement
   */
  public function getRecords($id) {   
    $conditions = "postid='$id'";
    return $this->get(array("conditions" => $conditions));
  }
	
 }	