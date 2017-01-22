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
class mOrderDetail extends fw\fwDao {
    /**
     * constructor
     */
    public function __construct()
    {
        appTrace(debug_backtrace());
        $this->table = "orderdetail";
    }
	
}