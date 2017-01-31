<?php
namespace  Netricite\Model\Shop;

use Netricite\Framework as fw;

/**
 * DAL: management of the SHOP object
 *
 * @author jp
 * @version 2016-13
 *
 */
class mShopProduct extends fw\fwDao {
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->table = "product";
    }
}