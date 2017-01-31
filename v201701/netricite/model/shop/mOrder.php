<?php
namespace  Netricite\Model\Shop;

use Netricite\Framework as fw;

/**
 * DAL: management of the SHOP object
 *
 * @author jp
 * @version 2016-11
 *
 */
class mOrder extends fw\fwDao {
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->table = "order";
    }
	
}