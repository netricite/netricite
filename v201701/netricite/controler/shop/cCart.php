<?php
namespace  Netricite\Controler\Shop;

use Netricite\Framework as fw;
use Netricite\Model\Shop as shop;


/**
 * @author jp
 * @version 2016-11
 *
 * cart controler
 */
class cCart extends fw\fwControlerSession {
  /**
   * constructor
   */
  public function __construct() {
  	appTrace(debug_backtrace()); 
    $this->model = new shop\mCart();
    $this->mOrder = new shop\mOrder();
    $this->mOrderDetail = new shop\mOrderDetail();
    
    if(isset($_SESSION['cart'])){
         watch($_SESSION['cart'], "cCart.__construct.session(cart)");
    } else {
        $_SESSION['cart'] = array();
    }
    
    if(isset($_POST['cart']['quantity'])){
        $this->recalculate();
    }
  }

  /**
   * Get application data
   * {@inheritDoc}
   * @see \Netricite\Framework\fwControler::getAppData()
   * @return array of application data
   */
  public function getAppData() {
      return array('data' => $this->model->getRecords());
  }
  /**
   * add 1 product to cart
   * @return string
   */
  public function add()
  {
    appTrace(debug_backtrace());
    appWatch($_GET, "request param", get_class($this));
    
    if (isset($_GET['id']))  {   
        //var_dump($_GET['id']);
        //var_dump($_SESSION['cart']);
        if(isset($_SESSION['cart'][$_GET['id']])){
			$_SESSION['cart'][$_GET['id']]++;
	   }else{
			$_SESSION['cart'][$_GET['id']] = 1;
	   } 
	}else {
	    throw new \Exception("cCart.add: Id is empty");
	}
	appWatch($_GET['id'], "id", get_class($this));
	appWatch($_SESSION['cart'], "cart", get_class($this));
	$_SESSION['cartTotal']=0;
	
	$this->redirect($this->application, "shop", null);
  }
  
  // remove items out of cart
  public function remove(){
      appTrace(debug_backtrace(), $_SESSION['cart']);
      
      if (isset($_GET['id']))  {
          appWatch($_GET['id'], "", get_class($this));
          if(isset($_SESSION['cart'][$_GET['id']])){
               unset($_SESSION['cart'][$_GET['id']]);
               
          }else{
              throw new \Exception("cCart.remove: Id not set");
          }
      }else {
          throw new \Exception("cCart.remove: Id is empty");
      }
         
      appWatch($_SESSION['cart'], "", get_class($this));
      $this->refreshPage();
  }
  /*
   * recalculate after delete
   */
  public function recalculate(){
      appTrace(debug_backtrace(), $_SESSION['cart']);
      foreach($_SESSION['cart'] as $product_id => $quantity){
          if(isset($_POST['cart']['quantity'][$product_id])){
              $_SESSION['cart'][$product_id] = $_POST['cart']['quantity'][$product_id];
          } else {
              throw new \Exception("cCart.recalculate: quantity is empty");
          }
      }
  }
  
  /*
   * recalculate after delete
   */
  public function total(){
      appTrace(debug_backtrace(), $_SESSION['cart']);
      
      $records = $this->model->getRecords();
      //var_dump($records);
      foreach($records as $record){
          if(isset($_POST['cart']['quantity'][$product_id])){
              $_SESSION['cart'][$product_id] = $_POST['cart']['quantity'][$product_id];
          } else {
              throw new \Exception("cCart.total: quantity is empty)");
          }
      }
  }
  
  // total amount in cart
  public function reset(){
      appTrace(debug_backtrace(), $_SESSION['cart']);
      $_SESSION['cart']= array();
      $this->redirect($this->application, "shop", null);
  }

}