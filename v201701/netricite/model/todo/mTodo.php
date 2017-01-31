<?php
namespace Netricite\Model\Todo;

use Netricite\Framework as fw;

/**
 * DAL: management of the @Application object
 *
 * @author jp
 * @version 2016-13
 *         
 */
class mTodo extends fw\fwDao
{

    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->table = "todo";
    }

    /**
     * get all the records of the table
     *
     * @return \Netricite\Framework\PDOStatement
     */
    public function getRecords()
    {
        if (isset($_SESSION['todoClass']) && isset($_SESSION['pseudo'])) {
            return $this->get(array(
                "conditions" => "type = '" . $_SESSION['todoClass'] . "' AND user = '" . $_SESSION['pseudo'] . "' ",
                "order" => "ORDER BY itemorder"
            ));
        } else {
            return $this->get(array(
                // "conditions" => "user = 'unknown'",
                "order" => "ORDER BY type"
            ));
        }
    }

    /**
     * get all the classes of the table
     *
     * @return \Netricite\Framework\PDOStatement
     */
    public function getClasses()
    {
        return $this->get(array(
            "fields" => "DISTINCT type",
            "order" => "ORDER BY type"
        ));
    }

    /**
     * update the current item
     *
     * @throws fw\fwException
     * @return string
     */
    public function updateOrder($id, $order)
    {
        $this->logger->addDebug($id . "/" . $order, debug_backtrace());
        
        try {
            $record = array(
                "id" => $id,
                "itemorder" => $order
            );
            $this->save($record);
        } catch (\Exception $e) {
            $this->logger->addError(".updateOrder" . $e->getMessage());
            throw new \Exception('updateOrder(error) : ' . $e->getMessage());
        }
    }
}