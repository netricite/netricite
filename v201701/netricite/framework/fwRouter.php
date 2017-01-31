<?php
namespace Netricite\Framework;

use Netricite\Framework as fw;

const CONTROLER_PREFIX = "c";
const INITIAL_APPLICATION = "site.application.index";
const DEFAULT_ACTION = "site.action.index";

//const DEFAULT_APPLICATION = "carousel";
//const DEFAULT_CLASS = "carousel";

/**
 * Route an incoming Http request to the associated controler
 *
 * @author jp
 * @version 2016-11
 *          
 * default parameters in dev.ini
 */
//
//mvcClass = controler, view, model
//application = blog             (default = dev.ini)
//class = blog post				 (default = application)
//prefix = v for view, c for controler, m for model
//action = blog post comment     (default = index)
//
//model:
//filename = mvcClass/application/prefix.class.ph
//
//usage:
//	controler/blog/cBlog.php
//	controler/blog/cpost.php
//	view/blog/vBlog.php
//	view/blog/vpost.php
//
//url format in action
//	action="index.php?application=blog&class=post&action=comment"
//

class fwRouter extends fwObject
{
    // filename associated to the current view
    private $controlerPath;
    /**
     * constructor
     *
     * @param unknown $parameters
     */
    public function __construct()
    {
        parent::__construct();
        //fwTrace(debug_backtrace());
        $this->controlerPath=fw\fwConfiguration::get("site.application.name") . "/" . fw\fwConfiguration::get("class.c") . "/";
        $this->logger->addDebug($this->controlerPath, debug_backtrace());
    }
    
    
    /**
     * Route an incoming Http request
     */
    public function routeRequest()
    {        
        $this->logger->addDebug(json_encode(array("SERVER_NAME"=>$_SERVER["SERVER_NAME"], 
            "ip client"=>$_SERVER["REMOTE_ADDR"],
            "QUERY_STRING"=>$_SERVER["QUERY_STRING"])), debug_backtrace());
        //fwTrace(debug_backtrace(), array("SERVER_NAME"=>$_SERVER["SERVER_NAME"], 
        //    "ip client"=>$_SERVER["REMOTE_ADDR"],
        //    "QUERY_STRING"=>$_SERVER["QUERY_STRING"]));
        // url parameter format : index.php?application=blog&action=post&id=1
        try {
            /*
             * Merge url parameters GET and POST of the request
             * Start sesssion
             */
            $request = new fw\fwRequest(array_merge($_GET, $_POST));
 
            /*
             * controler instance given by the application/class parameter
             */ 
            $controler = $this->createControler($request);           
            $action = $this->getAction($request);          
            $controler->executeAction($action);
            
        } catch (Exception $e) {
            errorMessage($e);
        }
    }

    /**
     * Create the controler associated with received url
     * 
     * @param fwRequest $request
     * @throws fw\fwException
     * @return unknown
     */
    private function createControler(fwRequest $request)
    {
        // url parameter format : index.php?application=blog&class=post&action=post&id=1
        //$application = DEFAULT_APPLICATION; // default application
        
        if ($request->isParameter('application')) {
            $application = strtolower($request->getParameter('application'));   
        } else {
            $application = fw\fwConfiguration::get(INITIAL_APPLICATION);   // default application dev.ini  
        }
        //fwWatch(array('createControler(application)') , $application, get_class($this));
        $this->logger->addInfo($application);
        // for namespace compatibility
        $class = $this->getClass($request);
        
        // Controler calls with a 'c' prefix
        $controlerClass = substr( fw\fwConfiguration::get("class.c") , 0,1 ) . ucfirst(strtolower($class));
        
        /*
         * manage Fully Qualified Class Name
         */
        $appClass = new fw\fwApplicationClass();
        $namespace = $appClass->getNamespace($application, $controlerClass);
        $pathClass = $appClass->getFilePath($namespace);
        
        if (file_exists($pathClass)) {
            /*
             * get controler class file
             */
            require ($pathClass);
            
            /*
             * new controler instance
             */
            //fwWatch(array('createControler(application)' => $application,'namespace' => $namespace), "", get_class($this));
            $this->logger->addInfo(json_encode(array('createControler(application)' => $application,'namespace' => $namespace)));
            $controler = new $namespace($application);
            $controler->setRequest($request);
            return $controler; // Return object controler
        } else
            throw new fw\fwException("file '$pathClass' not found");
    }

    /**
     * class is generated using the request parameter
     * 
     * @param fwRequest $request
     * @return string
     */
    private function getClass(fwRequest $request)
    {
        // url parameter format : index.php?application=blog&class=post&action=post&id=1
        // $class = DEFAULT_CLASS;

        if ($request->isParameter('class')) {
            $class = $request->getParameter('class');
            
        } else {
            $class = fw\fwConfiguration::get(INITIAL_APPLICATION);   // default class = application from dev.ini
        }
        
        //fwWatch(array('getClass(class)' => $class),"",get_class($this)); // debug
        $this->logger->addInfo($class);
        return $class;
    }
    
    /**
     * action is generated using the request parameter
     * 
     * @param fwRequest $request
     * @return string
     */
    private function getAction(fwRequest $request)
    { 
        /*
         *  url parameter format : index.php?application=blog&action=post&id=1
         */
        if ($request->isParameter('action')) {
            $action = $request->getParameter('action');       
        } else {
            $action = fw\fwConfiguration::get(DEFAULT_ACTION);   // default action from dev.ini
            //fwWatch(array('getAction(action)' => "DEFAULT_ACTION"),"",get_class($this));
            $this->logger->addInfo("DEFAULT_ACTION");
        }
        
        //fwWatch(array('getAction(action)' => $action),"",get_class($this) ); // debug
        $this->logger->addInfo($action);
        return $action;
    }
    
}