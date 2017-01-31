<?php
namespace Netricite\Framework;

use Netricite\Framework as fw;

const HOMEPAGE = "Location:index.php";

const LOGIN = "login";

/**
 * Process an incoming Http request send by the router
 *
 * @author jp
 * @version 2016-1
 *         
 */
abstract class fwControler extends fw\fwObject
{
    // current model
    protected $model;
    
    // Action to execute
    protected $action;
    
    // record
    protected $record;
    
    // incoming request parameters
    protected $request;
    
    // Current created id
    protected $id;
    
    // current application
    protected $application;
    
    // current class
    protected $class;

    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function initObject()
    {
        // create a log channel
        $this->logger = $this->initLogger("ctlr", TRUE);
        
        // add records to the log
        $this->logger->addInfo('initObject(' . get_class($this) . ")");
    }

    /**
     * Define the incoming request
     *
     * @param fwRequest $request            
     */
    public function setRequest(fwRequest $request)
    {
        $this->logger->addInfo('Parameters.');
        // $this->logger->addInfo('Parameters.' . json_encode($request->parameters));
        $this->request = $request;
    }

    /**
     *
     * display all records of the model
     *
     * {@inheritDoc}
     *
     * @see \Netricite\Framework\fwControler::index()
     */
    public function index()
    {
        // fwTrace(debug_backtrace());
        $this->logger->addDebug("index", debug_backtrace());
        if (! empty($this->model))
            $this->generateView($this->getAppData());
        else
            $this->generateView(array()); // no data
    }

    /**
     * Get application data
     *
     * @return array of application data
     */
    public function getAppData()
    {
        // fwTrace(debug_backtrace());
        $this->logger->addDebug("getAppData", debug_backtrace());
        $appdata = array(
            'data' => $this->get()
        );
        return $appdata;
    }

    /**
     * execute action
     *
     * @param unknown $action            
     * @throws fw\fwException
     */
    public function executeAction($action)
    {
        // fwTrace(debug_backtrace(), array('action' => $action));
        $this->logger->addDebug(json_encode(array(
            'action' => $action
        )), debug_backtrace());
        /*
         * manage Fully Qualified Class Name
         */
        $appClass = new fw\fwApplicationClass();
        $class = $appClass->getRelativeClass(get_class($this));
        // fwWatch($class, "", get_class($this));
        $this->application = strtolower($appClass->getApplication(get_class($this)));
        // fwWatch($this->application, "fw.controler(application)", get_class($this));
        $this->logger->addInfo($this->application);
        
        // user already authenticated or no authentication is required
        if (method_exists($this, $action)) {
            $this->action = $action;
            $this->{$this->action}();
        } else {
            fwTrace(debug_backtrace(), array(
                'action' => $action
            ));
            $currentClass = get_class($this);
            throw new \Exception("action($action) undefined in the class($currentClass)");
        }
    }

    /**
     * get records WHERE condition
     *
     * @param array $condition            
     *
     * @return related record
     */
    public function get($conditions = array())
    {
        $this->record = $this->model->get($conditions);
        return $this->record;
    }

    /**
     * get a record WHERE condition
     *
     * @param string $key            
     * @param string $condition            
     *
     * @return related record
     */
    public function getRecord($key, $condition = "")
    {
        $this->record = $this->model->getRecord($key, $condition);
        if (! empty($record)) {
            $this->id = $this->record['id']; // save record.id
        } else
            $this->id = - 1; // key not found
        return $this->record;
    }

    /**
     * Save (insert/update) a record
     *
     * @return true/false
     */
    public function save()
    {
        // fwTrace(debug_backtrace(), $data);
        $this->logger->addDebug($data, debug_backtrace());
        $rc = $this->saveData($_POST['data']);
        // refresh current page
        $this->refreshPage();
        exit();
    }

    /**
     * Save (insert/update) a record
     *
     * @return true/false
     */
    public function saveData($data)
    {
        // fwTrace(debug_backtrace(), $data);
        $this->logger->addDebug($data, debug_backtrace());
        if (! empty($data)) {
            $rc = $this->model->save($data);
            $this->id = $this->model->id;
            return $rc;
        }
    }

    /**
     * Save (insert/update) a record
     *
     * @return true/false
     */
    public function delete()
    {
        // fwTrace(debug_backtrace());
        $this->logger->addDebug("", debug_backtrace());
        if (! empty($_POST['data'])) {
            $rc = $this->model->delete($_POST['id']);
            // refresh current
            $this->refreshPage();
            return $rc;
        }
    }

    /**
     * generate the view associated with the current controler
     *
     * @param array $data            
     */
    protected function generateView($data = array())
    {
        $this->logger->addDebug("generateView", debug_backtrace());
        $this->logger->addInfo("#records." . count($data));
        
        // display the page
        $view = new fw\fwView(get_class($this), $this->application);
        $view->display($data);
    }

    /**
     * generate the view associated with the current controler
     */
    public function refreshPage()
    {
        error_log("fwControler.refreshPage===============********************");
        error_log("************** http request initiated ********************");
        error_log("**************========================*******refresh *****");
        
        unset($_POST['action']); // delete action url parameter (for refresh page purpose)
        $url = $_SERVER['PHP_SELF'] . "?" . $_SERVER["QUERY_STRING"];
        redirect($url);
    }

    /**
     * Redirect to the appropriate controler
     *
     * @param string $controler            
     * @param type $action            
     */
    protected function redirect($application, $class, $action = null)
    {
        // redirect to hme page if application is empty (explicit login from nav page)
        if (! $application == "") {
            /*
             * build redirect path to initial request
             */
            $redirect = $_SERVER['PHP_SELF'] . "?application=" . $application . "&class=" . $class;
            // $redirect = "/" . $GLOBALS["webRoot"] . "index.php?application=" . $application . "&class=" . $class ;
            if (! empty($action)) {
                $redirect .= "&" . $action;
            }
            // error_log("fwControler.redirect==================********************");
            // error_log("************** http request initiated ********************");
            // error_log("**************========================*****redirect*******");
            $this->logger->addNotice("http request initiated=======================********************");
            redirect($redirect);
        } else {
            // fwWatch(array('invalid application -> redirect(home)' => $application . "/" . $class ), "", get_class($this));
            $this->logger->addInfo(json_encode(array(
                'invalid application -> redirect(home)' => $application . "/" . $class
            )));
            $this->home();
        }
    }

    /**
     * back to home page
     */
    protected function home()
    {
        // force redirect to index page
        // error_log("fwControler.home=======================********************");
        // error_log("************** http request initiated ********************");
        // error_log("**************========================********************");
        $this->logger->addNotice("http request initiated=======================********************");
        unset($_POST['action']);
        $url = $_SERVER['PHP_SELF'];
        redirect($url);
    }

    /**
     * upload a file
     *
     * @param string $filename
     *            with path
     * @throws \Exception
     */
    public function uploadFile($filename)
    {
        // fwTrace(debug_backtrace(), $_FILES);
        $this->logger->addDebug(json_encode($_FILES), debug_backtrace());
        if (empty($_FILES))
            throw new \Exception("no selected file");
            // $target_dir = "D:/wamp/www/download/img/";
            
        // appWatch(array("input file"=>$_FILES["fileToUpload"],"filename"=>$filename),"", get_class($this));
        $this->logger->addInfo(json_encode(array(
            "input file" => $_FILES["fileToUpload"],
            "filename" => $filename
        )));
        $html = "";
        
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check) {
            $uploadOk = 1;
        } else {
            $html .= "<br />File is not an image.";
            $uploadOk = 0;
        }
        
        // Check if file already exists
        if (file_exists($filename)) {
            $html .= "<br />file already exists " . $filename;
            $uploadOk = 0;
        }
        // Check file size
        
        if ($_FILES["fileToUpload"]["size"] > 3100000) {
            $html .= "<br />your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        $imageFileType = pathinfo($filename, PATHINFO_EXTENSION);
        $file_display = array(
            'jpg',
            'jpeg',
            'png',
            'gif',
            'JPG',
            'JPEG',
            'PNG',
            'GIF'
        );
        if (! in_array($imageFileType, $file_display)) {
            $html .= "only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        
        if ($uploadOk == 0) {
            $html .= "<br />Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $filename)) {
                $html .= "<br />" . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
            } else {
                $html .= "<br />Sorry, there was an error uploading your file.";
            }
        }
        
        // REFRESH PAGE
        $html .= "</p>";
        info("I", $html);
        $this->refreshPage();
    }

    public function forceLogin()
    {
        // Force LOGIN
        $appClass = new fw\fwApplicationClass();
        $class = $appClass->getRelativeClass(get_class($this)); // get current class
                                                                
        // save next action to execute
        $_SESSION["nextClass"] = $class;
        $_SESSION["nextApplication"] = $this->application;
        
        // fwWatch(array("nextApplication"=>$this->application,"nextClass"=>$class), ".forceLogin", get_class($this));
        $this->logger->addInfo(json_encode(array(
            "nextApplication" => $this->application,
            "nextClass" => $class
        )));
        
        // force user to login
        $this->redirect(LOGIN, LOGIN);
    }
}