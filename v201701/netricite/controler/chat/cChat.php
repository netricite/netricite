<?php
namespace Netricite\Controler\Chat;

use Netricite\Framework as fw;
use Netricite\Model\Chat as chat;

/**
 *
 * @author jp
 * @version 2016-14
 *         
 *          chat controler
 *          user MUST be logon
 */
class cChat extends fw\fwControlerFilter
{
    /**
     * constructor
     */
    public function __construct()
    {
        appTrace(debug_backtrace());
        $this->model = new chat\mChat();
    }

    /**
     * Get application data
     * {@inheritDoc}
     * @see \Netricite\Framework\fwControler::getAppData()
     * @return array of application data
     */
    public function getAppData() {
        $appdata=array("records" => $this->model->getRecord($_SESSION['pseudo'], 0));
        return $appdata;
    }
    /**
     * publish a chat and send a mail
     * @return string
     */
    public function publish()
    {
        appTrace(debug_backtrace());
        if(!empty($_POST['data'])){
            sendMail($_POST['data']['message']);
            return $this->save();
        }      
    }
}
