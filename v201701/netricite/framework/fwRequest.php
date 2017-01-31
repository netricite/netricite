<?php

namespace Netricite\Framework;

use Netricite\Framework as fw;

/**
 * manage parameters of the http url parameters
 *
 * @author jp
 * @version 2016-1
 *
 */
class fwRequest extends fwObject
{
    /*
     * manage parameters of the http url parameters
     */ 
    public $parameters;
    /*
     * $_SESSION
     */ 
    private $session;

    /**
     * constructor
     * 
     * @param unknown $parameters
     */
    public function __construct($parameters)
    {
        parent::__construct();
        //fwTrace(debug_backtrace(), $parameters);
        $this->logger->addDebug("Parameters: " .json_encode($parameters), debug_backtrace());
        $this->parameters = $parameters;
        $this->session = new fw\fwSession();  
    }
    
    /**
     * Check whether the parameter exists in the request
     * 
     * @param unknown $parameter
     * @return boolean
     */
    public function isParameter($parameter)
    {
        return (!empty($this->parameters[$parameter]));
    }
    
    /**
     * Return parameter value
     * 
     * @param string $parameter
     * @return string
     */
    public function getParameter($parameter)
    {
        if ($this->isParameter($parameter)) {
            //fwWatch(array("getParameter(parameter)"=>$parameter), "" , get_class($this));
            $this->logger->addInfo($parameter);
            return $this->parameters[$parameter];
        } else
            //fwWatch($this->parameters, "url parameter '$parameter' missing in the request parameters", get_class($this));
            $this->logger->addInfo("",$this->parameters);
            return "";
    }
    
    /**
     * set url parameter
     * 
     * @param string $parameter
     * @param string $value
     */
     public function setParameter($parameter, $value='')
    {
        //fwWatch($this->parameters, "getParameter(parameters)", get_class($this));
        //fwWatch($parameter, "getParameter(parameter)", get_class($this));
        $this->logger->addInfo($parameter,$this->parameters);
        if (empty($value)) {
            //fwWatch(array("unset(parameter)"=>$parameter), "" , get_class($this));
            $this->logger->addInfo("unset parameter");
            unset($this->parameters[$parameter]);
            return;
        }
        if (!empty($this->parameters[$parameter])) {
            //fwWatch(array("setParameter(parameter)"=>$parameter), $value , get_class($this));
            $this->logger->addInfo("set parameter" . $value);
            $this->parameters[$parameter]=$value;
        } else
            //fwWatch($this->parameters, "url parameter '$parameter' missing in the url request parameters", get_class($this));
            $this->logger->addInfo("unknown parameter");
    }
    public function getParameters()
    {
        return $this->parameters;
    }
    
    /**
     * return session oject associated to the current request
     *
     * @return $_SESSION
     */
    public function getSession()
    {
        return $this->session;
    }
}