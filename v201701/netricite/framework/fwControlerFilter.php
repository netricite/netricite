<?php
namespace Netricite\Framework;

use Netricite\Framework as fw;

/**
 * check if user is logged in
 *
 * @author jp
 * @version 2016-1
 *
 */
abstract class fwControlerFilter extends fw\fwControlerSession
{

    /**
     * {@inheritDoc}
     * @see \Netricite\Framework\fwControler::executeAction()
     */
    public function executeAction($action)
    {
        //fwTrace(debug_backtrace(), array('action' => $action));
        $this->logger->addDebug(json_encode(array('action' => $action)));
        //is user already logon ?
        if (!empty($_SESSION["userid"])) {
            // execute required action
            parent::executeAction($action);
        } else {
            parent::forceLogin();
        }
    }
}