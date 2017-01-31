<?php
namespace  Netricite\Controler\Blog;

use Netricite\Framework as fw;
use Netricite\Model\Blog as blog;

/**
 * @author jp
 * @version 2016-13
 *
 * blog controler
 */
class cBlog extends fw\fwControlerSession  {

    /**
   * constructor
   */
  public function __construct() {
  	parent::__construct();
    $this->model = new blog\mBlog();
  }

}