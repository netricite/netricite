<?php
namespace Netricite\Framework;

use Netricite\Framework as fw;

/**
 * manage Fully Qualified Class Name
 *
 * @author jp
 * @version 2016-1
 *         
 */
class fwApplicationClass extends fw\fwObject
{

    /*
     * $_SESSION
     */
    // private $session;
    
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * return Fully Qualified Class
     */
    public function getRelativeClass($class)
    {
        $this->logger->addDebug($class, debug_backtrace());
        // fwTrace(debug_backtrace(),$class );
        $relativeClass = $class;
        /*
         * check if Fully Qualified Class Name
         */
        $members = explode(".", str_replace('\\', '.', $relativeClass));
        // fwWatch($members + array( "getRelativeClass(count)" => count($members)), "", get_class($this));
        
        if (count($members) > 1) {
            /*
             * manage Fully Qualified Class Name
             */
            $relativeClass = substr($members[count($members) - 1], 1); // extract root class from fully qualified class
        } else {
            /*
             * manage relative class
             */
            $relativeClass = substr(get_class($this), 1);
        }
        /*
         * return namespace
         */
        // fwWatch($relativeClass, "", get_class($this));
        return $relativeClass;
    }

    /**
     * return Fully Qualified Class
     */
    public function getApplication($class)
    {
        // fwTrace(debug_backtrace(),$class );
        $this->logger->addDebug($class, debug_backtrace());
        /*
         * check if Fully Qualified Class Name
         */
        $members = explode(".", str_replace('\\', '.', $class));
        // fwWatch($members + array("getApplication(count)" => count($members)),"", get_class($this));
        
        if (count($members) > 1) {
            /*
             * manage Fully Qualified Class Name
             */
            $application = $members[count($members) - 2]; // extract application from fully qualified class
        } else {
            /*
             * manage relative class
             */
            $application = substr($class, 1);
        }
        /*
         * return namespace
         */
        // fwWatch($application, "", get_class($this));
        $this->logger->addInfo($application);
        return $application;
    }

    /**
     * return Fully Qualified Class
     */
    public function buildNamespace($class)
    {
        $relativeClass = $this->getRelativeClass($class);
        $application = $this->getApplication($class);
        
        /*
         * return namespace
         */
        $namespace = $this->getNamespace($application, $relativeClass);
        // fwWatch (array("buildNamespace(application)" & $application, "namespace"=> $namespace), "", get_class($this));
        $this->logger->addInfo($namespace, array(
            "buildNamespace(application)" & $application,
            "namespace" => $namespace
        ));
        return $namespace;
    }

    /**
     * return Fully Qualified Class
     */
    public function getNamespace($application, $class)
    {
        // fwWatch(array('getNamespace(application)' => $application, 'class' => $class), "", get_class($this));
        $this->logger->addDebug($class, debug_backtrace());
        $this->logger->addInfo($application . "/" . $class);
        
        $classPrefix = "class." . substr($class, 0, 1); // first letter of the class
        $application = strtolower($application); // application to lower case
        /*
         * get namespace from configuration
         */
        $namespace = fw\fwConfiguration::get("site.application.name") . "." . fw\fwConfiguration::get($classPrefix, ".namespace not found.") . "." . $application . "." . $class;
        $namespace = str_replace('.', '\\', $namespace);
        // fwWatch (array("getNamespace(class prefix)"=> $classPrefix, "namespace"=> $namespace), "", get_class($this));
        $this->logger->addInfo("getNamespace." . $namespace . "/ class prefix." . $classPrefix);
        return $namespace;
    }

    /**
     * return path of the Fully Qualified Class Name
     */
    public function getFilePath($namespaceClass)
    {
        $filePath = str_replace('\\', '/', $namespaceClass) . '.php';
        // fwWatch (array("getFilePath(file path)"=> $filePath), "", get_class($this));
        $this->logger->addInfo("getFilePath." . $filePath . "/ file path." . $filePath);
        return $filePath;
    }
}