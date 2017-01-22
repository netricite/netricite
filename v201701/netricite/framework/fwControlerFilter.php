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
        fwTrace(debug_backtrace(), array('action' => $action));
        //is user already logon ?
        if (!empty($_SESSION["userid"])) {
            // execute required action
            parent::executeAction($action);
        } else {
            parent::forceLogin();
            /*
            // Force LOGIN 
            $appClass = new fw\fwApplicationClass();
            $class = $appClass->getRelativeClass(get_class($this));                 //get current class
            
            //save next action to execute
            $_SESSION["nextClass"]=$class;
            $_SESSION["nextClass"]=$this->application;
            
            fwWatch(array("executeAction(nextApplication)"=>$this->application,
                "nextClass"=>$class), "", get_class($this));
            
            // force user to login
            $this->redirect(LOGIN, LOGIN);
            */
        }
    }
}