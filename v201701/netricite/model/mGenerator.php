<?php
namespace  Netricite\Model\@Application;

use Netricite\Framework as fw;
/**
 * DAL: management of the @Application object
 *
 * @author jp
 * @version 2016-14
 *
 */
class m@Application extends fw\fwDao {
    /**
     * constructor
     */
    public function __construct()
    {
                appTrace(debug_backtrace());
        $this->table = "@table";
    }
}