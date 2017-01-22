<?php
namespace Netricite\Framework;

use Netricite\Framework as fw;

/**
 * Add session info to html view
 *
 * @author jp
 * @version 2016-1
 */
abstract class fwControlerSession extends fw\fwControler
{

    /**
     * Add session info to html view
     *
     * @param type $data
     *            dynamic session data
     * @param type $action
     *            associated action to current view
     */
    protected function generateView($data = array(), $action = null)
    {   
        
        $pseudo=!empty( $_SESSION["pseudo"] ) ?  $pseudo = $_SESSION["pseudo"] : "";
        $cart=!empty( $_SESSION["cart"] ) ?  $cart = $_SESSION["cart"] : "";
        
        parent::generateView($data + array('pseudo' =>$pseudo,'cart' => $cart), 
            $action);
    }
}