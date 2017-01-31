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
  
  /**
   * Generate an order and then a payment
   * @throws \Exception
   */
  public function payment() {
      if (!empty($_SESSION["userid"])) {
          $order= new app\Payment();
          if ($order->payment($this->getAppData())) {
              $this->logger->addDebug("Payment operation completed " . $_SESSION['cart']);
              info("I", "Phase d'initialisation du pPaiement terminée avec succès.");
              //$this->redirect("shop","payment","done");
          } else  {
              info("I", "Le paiement n'a pas été effectué, vous ne serez pas débité.");
              $this->logger->addError("Payment failed ");
              //$this->refreshPage();
          }
          
      } else {
          info("I", "Merci de vous logger, avant de commander.");
          $this->forceLogin();
      }
  }
  
  public function paypalReturn() {
      $this->logger->addDebug("paypalReturn", debug_backtrace());
      $this->logger->addInfo("GET", $_GET);
      $payment= new app\PaymentPaypal();
      if (!$payment->paypalReturn()) return FALSE;
      return TRUE;
  }
 
  public function paypalCancel() {
      $this->logger->addDebug("paypalCancel", debug_backtrace());
      $this->logger->addInfo("GET", $_GET);

      $payment= new app\PaymentPaypal();
      if (!$payment->paypalCancel()) return FALSE;
      return TRUE;
  }
  
  public function invoice() {
      $this->logger->addDebug("invoice", debug_backtrace());
      $this->logger->addInfo("POST", $_POST);
  
      $payment= new app\Payment();
      if (!$payment->invoice($this->request->parameters)) return FALSE;
      return TRUE;
  }
}