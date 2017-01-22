<?php
namespace  Netricite\Controler\Slider;

use Netricite\Framework as fw;
use Netricite\Model\Slider as slider;


const APPLICATION = "slider";

/**
 * @author jp
 * @version 2016-14
 *
 * slider controler
 */
class cSlider extends fw\fwControlerSession {

  /**
   * constructor
   */
  public function __construct() {
  	appTrace(debug_backtrace());

    $this->model = new slider\mSlider();
  }

}