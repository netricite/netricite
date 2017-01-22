<?php
namespace  Netricite\Controler\Root;

use Netricite\Framework as fw;
use Netricite\Model\Blog as blog;

/**
 * @author jp
 * @version 2016-12
 *
 * Application controler
 */
class cRoot extends fw\fwControlerSession {         //session tpe : without login

  /**
   * constructor
   */
  public function __construct() {
  	appTrace(debug_backtrace()); 
	
  	$this->model = new blog\mComment();
  }

  /**
   * Get application data
   * {@inheritDoc}
   * @see \Netricite\Framework\fwControler::getAppData()
   * @return array of application data
   */
  public function getAppData() {
          return array('records' => null);
  }

   /**
     * add a comment in the blog "Livre d'or - le traineau"
     */
  public function comment() {
   appTrace(debug_backtrace());
   $model->save($_POST['data']);                   
   //REFRESH PAGE
   $this->refreshPage();
 }
}