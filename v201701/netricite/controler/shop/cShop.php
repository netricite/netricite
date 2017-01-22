<?php
namespace  Netricite\Controler\Shop;

use Netricite\Framework as fw;
use Netricite\Model\Shop as shop;
use Netricite\Model\Blog as blog;
use Netricite\Model\Todo as todo;

/**
 * @author jp
 * @version 2016-13
 *
 * shop controler
 */
class cShop extends fw\fwControlerSession {

  /**
   * constructor
   */
  public function __construct() {
  	appTrace(debug_backtrace()); 
    $this->model = new shop\mShop();
  }

  
  /**
   * Booking
   */
  public function booking() {
      appTrace(debug_backtrace()); 
      
      $device="";
      //var_dump($_POST);
      //var_dump($this->request->getParameters());
      if (!empty($_POST['data']['booking'])){
          $device="avec un appareil";
      }
      if (!empty($_POST['data']['fondue'])){
          $product=$_POST['data']['fondue'][0];
      }
      if (!empty($_POST['data']['raclette'])){
          $product=$_POST['data']['raclette'][0];
      }
      if (!empty($_POST['data']['huitre'])){
          $product=$_POST['data']['huitre'][0];
      }
      
      $client= $_POST['data']['user'];
      $comment= "Je reserve " . strtoupper($product) . " pour " . $_POST['data']['count'] . " personnes ". strtoupper($device) . "\r\n" . $this->request->parameters['data']['comment'];
      $_POST['data']['comment']=$comment ;
      //$this->request->parameters['data']['comment']="Je reserve une " . $_POST['data']['booking'][0] . " pour " . $_POST['data']['count'] . " personnes ".$device . "\n" . $this->request->parameters['data']['comment'];
      //unset($this->request->parameters['data']['booking']);
      //unset($this->request->parameters['data']['booking']);
      //unset($this->request->parameters['data']['count']);
      unset( $_POST['data']['booking']);
      unset( $_POST['data']['count']);
      unset( $_POST['data']['fondue']);
      unset( $_POST['data']['raclette']);
      unset( $_POST['data']['huitre']);
      //var_dump($_POST['data']);
      //var_dump($this->request->getParameters());
      // SAVE a COMMENT
      $model = new blog\mComment();
      $model->save($_POST['data']);                                         //create 
      $title = "Booking ref:'" . $model->id  . "' for " . $client;
      $_POST['data']['comment']=$title . "\r\n" . $comment ;
      $_POST['data']['id']=$model->id;                                      //update last record
      $model->save($_POST['data']);
      
      
      // EMAIL CONFIRMATION
      $mail = fw\fwConfiguration::get("company.email");   // from dev.ini
      sendMail($comment,
          $mail, 
          $title , 
          $client, 
          $client
          );
      
      //ADD a TODO TASK
      $user = fw\fwConfiguration::get("company.admin");   // from dev.ini
      $data=array("title"=> $title, 
          "milestone"=>date('Y-m-d H:i:s'), 
          "note" =>$comment, 
          "type"=> "BOOKING", 
          "user"=>$user,
          "status"=> "0",
          "itemorder"=> "0",
          );
      $model = new todo\mTodo();
      $model->save($data);
      
      //REFRESH PAGE
      $this->refreshPage();
      
  }
}