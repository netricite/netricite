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
class c@Application extends fw\fwControlerSession {         //session type : without login
class c@Application extends fw\fwControlerFilter {          //session type : login required

  private $class;

  /**
   * constructor
   */
  public function __construct() {
  	parent::__construct();
    $this->model = new @application\m@Application();
  }
}