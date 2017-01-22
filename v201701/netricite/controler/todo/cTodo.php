<?php
namespace  Netricite\Controler\Todo;

use Netricite\Framework as fw;
use Netricite\Model\Todo as todo;

/**
 * @author jp
 * @version 2016-14
 *
 * application controler
 */
class cTodo extends fw\fwControlerFilter {                 //User must be loggin

    //Array that stores the todo item data
    private $data;
    
  /**
   * constructor
   */
  public function __construct() {
  	appTrace(debug_backtrace());
    $this->model = new todo\mTodo();
  }

  // load object value 
  public function set($data){
      if(is_array($data))
          $this->data = $data;
  }
  
  /**
   * Get application data
   * {@inheritDoc}
   * @see \Netricite\Framework\fwControler::getAppData()
   * @return array of application data
   */
  public function getAppData() {
      return array('records' => $this->model->getRecords(),
        'classes' => $this->model->getClasses());
  }
  
  /**
   * update the current item
   * 
   * @return string
   */
  public function updateDelete()
  {
      appTrace(debug_backtrace());
      
      if ($_POST["operation"]=="save") {       
          $this->model->save($_POST['data']);
      } elseif ($_POST["operation"]=="delete") {
          $this->model->delete($_POST['data']["id"]);
      }
      // refresh page with updated information
      $this->refreshPage();
  }  
}