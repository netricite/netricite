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
class mCart extends fw\fwDao {   
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->table = "product";
    }
    
    // items in cart
    public function getRecords(){
        //appTrace(debug_backtrace(),$_SESSION['cart']);
        $this->logger->addDebug("getRecords", debug_backtrace());
        $this->logger->addInfo("cart",$_SESSION['cart']);
        
        $ids = array_keys($_SESSION['cart']);
        $this->logger->addInfo("mCart.getRecords(id)", $ids);
        if(empty($ids)){
            $records = array();
        }else{
           $conditions = 'id IN ('.implode(',',$ids).')';
           $records = $this->get(array(
                "conditions" => $conditions
            ));
        }
        $this->logger->addInfo("data", $records);
        return $records;
    }
}