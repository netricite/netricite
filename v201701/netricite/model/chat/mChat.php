<?php
namespace Netricite\Model\Chat;

use Netricite\Framework as fw;

/**
 * DAL: management of the CHAT object
 *
 * @author jp
 * @version 2016-14
 *
 */
class mChat extends fw\fwDao
{
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->table = "chat";
    }
       
    /**
     * get all records matching criteria
     *
     * @param string $pseudo
     *            sender or receiver of chat message
     * @return \Netricite\Framework\PDOStatement
     */
    public function getRecord($pseudo, $status=0)
    {
        $conditions = "sender='$pseudo' OR destinee='$pseudo' AND status=$status ";
        return $this->get(array("conditions" => $conditions
        ));
    }
    
    /**
     * message status update
     * 
     * @param int $p1
     * @param unknown $p2
     * @throws fw\fwException
     */
    public function updateStatus($id, $status)
    {
        try {
            $sql = ('UPDATE ".$this->table." set status=?  WHERE id=? ');
            if ($this->update($sql, array(
                $status,
                $id
            ))) {
                return 'updated  -> ' . $id;
            }
        } catch (Exception $e) {
            throw new fw\fwException('mChat.update error : ' . $e->getMessage());
        }
    }
  
    /**
     * return #count of new messages
     *
     * @return int count
     */
    public function countNewMessage($pseudo)
    {
        $conditions = "destinee='$pseudo' AND status=1";
        return $this->count(array("conditions" => $conditions
        ));
    }
}