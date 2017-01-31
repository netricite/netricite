<?php
namespace  Netricite\Controler\Shop;

use Netricite\Framework as fw;
use Netricite\Model\Shop as shop;

/**
 * @author jp
 * @version 2016-13
 *
 * product controler
 */
class cShopProduct extends fw\fwControlerSession {

  /**
   * constructor
   */
  public function __construct() {
  	parent::__construct();  
    $this->model = new shop\mShopProduct();
  }

}