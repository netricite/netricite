<?php
namespace  Netricite\Controler\@Application;

use Netricite\Framework as fw;
use Netricite\Model\@Application as @application;

/**
 * @author jp
 * @version 2016-12
 *
 * Application controler
 */
class c@Application extends fw\fwControlerSession {         //session tpe : without login
class c@Application extends fw\fwControlerFilter {          //session tpe : login required

  private $class;

  /**
   * constructor
   */
  public function __construct() {
  	appTrace(debug_backtrace());
    $this->model = new @application\m@Application();
  }
}