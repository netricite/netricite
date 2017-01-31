<?php
namespace  Netricite\Controler\Shop;

use Netricite\Framework as fw;
use Netricite\Model\Shop as shop;
use Netricite\Model\Login as login;
use Netricite\AppClass as app;

/**
 * @author jp
 * @version 2016-14
 *
 * shop controler
 */
class cOrder extends fw\fwControlerFilter {

  /**
   * constructor
   */
  public function __construct() {
  	parent::__construct(); 
  	$this->model = new shop\mOrder();
    $this->mUser = new login\mUser();
    $this->mOrderDetail = new shop\mOrderDetail();
    $this->mShopProduct = new shop\mShopProduct();
    $this->mCart = new shop\mCart();
  }
  
 /**
   * Get application data
   * {@inheritDoc}
   * @see \Netricite\Framework\fwControler::getAppData()
   * @return array of application data
   */
  public function getAppData() {
      $this->logger->addDebug("getAppData", debug_backtrace());
      // get orders and user
      $appdata=array("data"=>$this->model->get(array("conditions"=> "clientid=" .$_SESSION['userid'])),
          "userdata"=>$this->mUser->getRecord($_SESSION['userid'],"id"));
      return $appdata;
  }
 
  
}