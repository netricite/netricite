<?php
namespace  Netricite\Controler\About;

use Netricite\Framework as fw;

/**
 * @author jp
 * @version 2016-14
 *
 * about controler
 */
class cAbout extends fw\fwControler {
  /**
   * constructor
   */
  public function __construct() {
  	appTrace(debug_backtrace()); 
  }
}
