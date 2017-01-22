<?php
namespace Netricite\Framework;

/**
 * Custom Application Exception Management
 *
 * @author jp
 * @version 2016-14
 *
 *
 */
class fwException extends \ErrorException
{

    /**
     * {@inheritDoc}
     * @see ErrorException::__toString()
     */
    public function __toString()
    {
        switch ($this->severity) {
            case E_USER_ERROR:
                $type = 'Fatal';
                break;
            
            case E_WARNING:
            case E_USER_WARNING:
                $type = 'Warning';
                break;
            
            case E_NOTICE:
            case E_USER_NOTICE:
                $type = 'Note';
                break;
            
            default:
                $type = 'Error';
                break;
        }
        $message = '<strong>' . $type . '</strong> : [' . $this->code . '] ' 
               . $this->message . '<br />\n<strong>' 
               . $this->file 
               . '</strong>@line<strong>' . $this->line . '</strong><br />\n' .
               'PHP ' . PHP_VERSION . ' (' . PHP_OS . ')<br />\n' .
               'Execution of the script has been stopped<br />\n';
        return $message;
    }
}