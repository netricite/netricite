<?php
namespace  Netricite\Controler\Shop;

use Netricite\Framework as fw;
use Netricite\Model\Shop as shop;
use Netricite\Model\Login as login;

/**
 * @author jp
 * @version 2016-14
 *
 * shop controler
 */
class cAccount extends fw\fwControlerFilter {

  /**
   * constructor
   */
  public function __construct() {
  	parent::__construct(); 
    $this->model = new login\mUser();
    $this->mOrder = new shop\mOrder();
  }

  /**
   * Get application data
   * {@inheritDoc}
   * @see \Netricite\Framework\fwControler::getAppData()
   * @return array of application data
   */
  public function getAppData() {
      return array('data' => $this->getRecord($_SESSION['userid']), 
              'order'=> $this->mOrder->getRecord($_SESSION['userid'], "clientid"), 
              'delivery'=> $this->mOrder->getRecord($_SESSION['userid'], "clientid"), 
              'payment'=> $this->mOrder->getRecord($_SESSION['userid'], "clientid") );
  }
  
}