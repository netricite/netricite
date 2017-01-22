<?php
namespace  Netricite\Model\Slider;

use Netricite\Framework as fw;

const OBJECT_TABLE = "slider";

/**
 * DAL: management of the slider object
 *
 * @author jp
 * @version 2016-11
 *
 */
class mSlider extends fw\fwDao {

  /**
   * get all the records of the object table
   * 
   * @return \Netricite\Framework\PDOStatement
   */
  public function getRecords() {
    $sql = 'SELECT * FROM ' . OBJECT_TABLE . ' ORDER BY id';
    $records = $this->get($sql);
    return $records;
  }
	
	/**
     * return #count
     * 
     * @return int count
     */
	  public function count($table="") {
		return parent::count(OBJECT_TABLE);
    }
	
}