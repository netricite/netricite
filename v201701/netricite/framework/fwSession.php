<?php
namespace Netricite\Framework;

use Netricite\Framework as fw;

/**
 * SESSION management
 *   encapsulate PHP superglobal $_SESSION
 *  
 * @author jp
 * @version 2016-1
 *
 */
class fwSession
{
    /**
     * start or restaure the session
     */
    public function __construct()
    {
        if(!isset($_SESSION))
        {   
            session_start();
            
            if (fw\fwConfiguration::get("user.language")=="user") $_SESSION['lang'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            else $_SESSION['lang'] = fw\fwConfiguration::get("company.language") ;
            fwTrace(debug_backtrace(), "", "Session starts,['language'](" . $_SESSION['lang'] .")");
            
            //init cart info
            if (!isset($_SESSION['cart'])) $_SESSION['cart']=array();
            
        }
    }

    /**
     * destroy current session
     */
    public function destroy()
    {
        fwTrace(debug_backtrace());
        session_destroy();
    }
    
}