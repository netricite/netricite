<?php
namespace Netricite\Framework;

use Netricite\Framework as fw;

/**
 * Manage the current view displayed via VIEW_TEMPLATE
 *
 * @author jp
 * @version 2016-1
 *
 *
 */
class fwView
{
    // path associated to the view
    private $viewPath;
    // filename associated to the current view
    private $viewFile;
    // filename associated to the current view
    private $viewTemplate;
    // view title (definied in the view file)
    private $title;
    // form generator
    public $formgen;
    /**
     * constructor 
     * 
     * @param unknown $action
     * @param string $application
     */
    public function __construct($action, $application = "")
    {
        fwTrace(debug_backtrace(), array('__construct(action)' => $action, 'application' => $application) );     
         
        //default value
        $view = $action;
        $baseApplication = $application;
        
        $members = explode(".", str_replace('\\', '.', $action));
        //fwWatch($members + array("__construct(count)" => count($members)), "", get_class($this));
        
        //extract parameters
        if (count($members) > 1) {
             //manage Fully Qualified Class Name
            $view =  substr($members[count($members) - 1], 1);      // extract root class from fully qualified class
            $baseApplication =  $members[count($members) - 2];      // extract application from fully qualified class
            //fwWatch(array('__construct(view)' => $view), "", get_class($this));
        }
        
        // filepath created from application and action
        $this->viewPath=fw\fwConfiguration::get("site.application.name") . "/" . fw\fwConfiguration::get("class.v") . "/";
        $path = $this->viewPath;
        if ( !empty($baseApplication) ) {
            $path .= $baseApplication . "/";
        }
        
        $this->viewFile = $path . substr( fw\fwConfiguration::get("class.v"),0,1) . ucfirst(strtolower($view)) . ".php";
        
        $this->viewTemplate = $this->viewPath . fw\fwConfiguration::get("view.template");
        fwWatch(array("__construct(viewPath)" =>  $this->viewPath, '__construct(viewTemplate)' => $this->viewTemplate,
            '__construct(viewFile)' => $this->viewFile), "", get_class($this));
    }

        
    /**
     * generate and display the view
     * 
     * @param array $data
     */
    public function display($data)
    {                                
        fwTrace( debug_backtrace(), array( "viewFile"=> $this->viewFile ));
        
        // add data given by the controler to the page
        $content = $this->htmlContent( $this->viewFile, $data );
        
        // generate template with the specific part of the view
        $htmlView = $this->htmlContent( $this->viewTemplate, $data + array(
            'title' => $this->title,
            'content' => $content));
        
        // display the html page
        echo $htmlView;
    }
    
    /**
     * Generate a view file and return it
     * 
     * @param string $filename
     * @param array $data
     * @throws fw\fwException
     * @return string
     */
    private function htmlContent($filename, $data)
    {
        fwTrace( debug_backtrace(), array( "htmlContent(filename)"=> $filename ) );
        
        if (file_exists($filename)) {
            // data are imported to the symbol table and accessible by the view
            extract($data);
            // Open output buffer
            ob_start();
            // include the file in the output buffer
            require $filename;
            // return the output buffer
            return ob_get_clean();
        } else {
            throw new \Exception("htmlContent(file) '$filename' not found");
        }
    }
}