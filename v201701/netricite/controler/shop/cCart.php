<?php
namespace Netricite\Controler\Shop;

use Netricite\Framework as fw;
use Netricite\Model\Shop as shop;

/**
 *
 * @author jp
 * @version 2016-11
 *         
 *          cart controler
 */
class cCart extends fw\fwControlerSession
{

    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new shop\mCart();
        $this->mOrder = new shop\mOrder();
        $this->mOrderDetail = new shop\mOrderDetail();
        
        if (isset($_SESSION['cart'])) {
            $this->logger->addInfo("cart", $_SESSION['cart']);
        } else {
            $_SESSION['cart'] = array();
        }
        
        if (isset($_POST['cart']['quantity'])) {
            $this->recalculate();
        }
    }

    /**
     * Get application data
     *
     * {@inheritDoc}
     *
     * @see \Netricite\Framework\fwControler::getAppData()
     * @return array of application data
     */
    public function getAppData()
    {
        return array(
            'data' => $this->model->getRecords()
        );
    }

    /**
     * add 1 product to cart
     *
     * @return string
     */
    public function add()
    {
        // $this->logger->addDebug("add", debug_backtrace());
        // $this->logger->addInfo("GET", $_GET);
        $json = array(
            'error' => "TRUE",
            'message' => 'cannot add product to cart'
        );
        if (isset($_GET['id'])) {
            // var_dump($_GET['id']);
            // var_dump($_SESSION['cart']);
            if (isset($_SESSION['cart'][$_GET['id']])) {
                $_SESSION['cart'][$_GET['id']] ++;
            } else {
                $_SESSION['cart'][$_GET['id']] = 1;
            }
        } else {
            throw new \Exception("cCart.add: Id is empty");
        }
        // $this->logger->addInfo("Product: " . $_GET['id'], $_SESSION['cart']);
        $_SESSION['cartTotal'] = 0;
        $json['error'] = "FALSE";
        $json['message'] = "product added to cart " . array_sum($_SESSION['cart']);
        $json['count'] = array_sum($_SESSION['cart']);
        // $this->logger->addInfo("json: ", $json);
        // return json_encode($json);
        return $json;
        // $this->redirect($this->application, "shop", null);
    }
    
    // remove items out of cart
    public function remove()
    {
        // appTrace(debug_backtrace(), $_SESSION['cart']);
        $this->logger->addDebug("remove", debug_backtrace());
        if (isset($_GET['id'])) {
            $this->logger->addInfo($_GET['id'], $_SESSION['cart']);
            if (! empty($_SESSION['cart'][$_GET['id']])) {
                $this->logger->addInfo("remove: " . $_GET['id'], $_SESSION['cart']);
                unset($_SESSION['cart'][$_GET['id']]);
            } else {
                $this->logger->addError("cCart.remove: Id not set", $_SESSION['cart']);
            }
        } else {
            $this->logger->addError("cCart.remove: Id is empty", $_SESSION['cart']);
        }
        
        // appWatch($_SESSION['cart'], "", get_class($this));
        $this->logger->addInfo("remove", $_SESSION['cart']);
        // $this->refreshPage();
        $this->redirect($this->application, "cart", null);
    }

    /*
     * recalculate after delete
     */
    public function recalculate()
    {
        // appTrace(debug_backtrace(), $_SESSION['cart']);
        $this->logger->addDebug(json_encode($_SESSION['cart']), debug_backtrace());
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            if (isset($_POST['cart']['quantity'][$product_id])) {
                $_SESSION['cart'][$product_id] = $_POST['cart']['quantity'][$product_id];
            } else {
                throw new \Exception("cCart.recalculate: quantity is empty");
            }
        }
    }

    /*
     * recalculate after delete
     */
    public function total()
    {
        // appTrace(debug_backtrace(), $_SESSION['cart']);
        $this->logger->addDebug(json_encode($_SESSION['cart']), debug_backtrace());
        $records = $this->model->getRecords();
        // var_dump($records);
        foreach ($records as $record) {
            if (isset($_POST['cart']['quantity'][$product_id])) {
                $_SESSION['cart'][$product_id] = $_POST['cart']['quantity'][$product_id];
            } else {
                throw new \Exception("cCart.total: quantity is empty)");
            }
        }
    }
    
    // total amount in cart
    public function reset()
    {
        // appTrace(debug_backtrace(), $_SESSION['cart']);
        $this->logger->addDebug("reset", debug_backtrace());
        $_SESSION['cart'] = array();
        $this->redirect($this->application, "shop", null);
    }
}