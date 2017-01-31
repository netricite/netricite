<?php
namespace Netricite\Framework;

use Netricite\Framework as fw;
use Netricite\AppClass\appObject;

/**
 * @author jp
 * @version 201701
 *
 * company information is located in config.ini
 */

abstract class fwObject  extends appObject {
    
    public function initObject() {
        // create a log channel
        $this->logger = $this->initLogger(fw\fwConfiguration::get('trace.channel.framework'), TRUE);
    
        // add records to the log
        $this->logger->addDEBUG('initObject(' . get_class($this) . ")");
    }
}
