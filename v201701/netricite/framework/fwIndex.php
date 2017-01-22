<?php
use Netricite\Framework as fw;

$rootpath = realpath(__DIR__ . '/../..') ."/";
error_log("fwIndex.php - root path: " . $rootpath);
/*
 * application constants
 */
error_log("*********** fwIndex.php **************************");

// Report all errors
error_reporting(E_ALL);
set_exception_handler('exception_handler');
// get configuration params from config PROD file
$inifile = PROD;
if (! file_exists($inifile)) {
    // get configuration params from config DEV file
    $inifile = DEV;
    set_error_handler("error_handler");
    //set_exception_handler('customError');
} else {
    //PROD env
    set_error_handler("customError");
}
error_log("inifile:" . $inifile);
/*
 * load Debug and Helpers
 */
$rootpath = realpath(__DIR__) ;
error_log("fwIndex.php - root path: " . $rootpath);
require $rootpath."/fwConfiguration.php";
require $rootpath.'/fwDebug.php';
require $rootpath.'/fwHelpers.php';


//CONFIG
$config=new fw\fwConfiguration(parse_ini_file($inifile));                                         

//APPLICATION CONFIG
$GLOBALS["application.index"]= $config->get("site.application.index");         // get version from dev.ini

//GOOGLE CONFIG
$GLOBALS["google.clientID"]= $config->get("google.clientID");
$GLOBALS["google.publickey.API"]= $config->get("google.publickey.API");   
$GLOBALS["google.secretkey.API"]= $config->get("google.secretkey.API");
$GLOBALS["google.publickey.recaptcha"]= $config->get("google.publickey.recaptcha");
$GLOBALS["google.secretkey.recaptcha"]= $config->get("google.secretkey.recaptcha");

// APPLICATION PATH
$GLOBALS["application.version"] = $config->get("site.application.version") ;
$GLOBALS["web.base"] = $config->get("site.root") . "/" . $GLOBALS["application.version"]  . "/" ;
$GLOBALS["application.path"] = $_SERVER['DOCUMENT_ROOT'] . $GLOBALS["web.base"] ;
$GLOBALS["application.root.path"] = $GLOBALS["application.path"] . $config->get("site.application.name") . "/";
$GLOBALS["application.imgsrc"] = $config->get("site.application.image.path");
$GLOBALS["site.imgsrc"] = $config->get("site.download.path");
$GLOBALS["site.download.path"] = $_SERVER['DOCUMENT_ROOT'] . $config->get("site.download.path");
$GLOBALS["site.fpdf.path"] = $_SERVER['DOCUMENT_ROOT'] . $config->get("site.fpdf.path");
$GLOBALS["site.report.path"] = $GLOBALS["application.root.path"] . $config->get("site.report.path");
const ERROR_PAGE = "Error";
try {
/*
 * autoloader implicit require
 * @see fwHelpers.php
 */
spl_autoload_register('classAutoLoader');

/*
 * execution trace 
 * @see fwDebug.php
 */
startTrace();

watch($GLOBALS["web.base"],"GLOBALS.web.base");
watch($GLOBALS["application.path"],"GLOBALS.application.path");
watch($GLOBALS["application.root.path"],"GLOBALS.application.root.path");
watch($GLOBALS["application.imgsrc"],"GLOBALS.application.imgsrc");
watch($GLOBALS["site.download.path"],"GLOBALS.site.download.path");
watch($GLOBALS["site.report.path"],"GLOBALS.site.report.path");
watch($GLOBALS["site.imgsrc"],"GLOBALS.site.imgsrc");

error_log("============ fwIndex.php completed with success =============================");

} catch (\Exception $e) {
    throw new \Exception($e->getMessage());
}


/*
 * exception handler for uncaught exceptions
 */
function exception_handler($e) {
    //var_dump($e);
    switch ($e->getCode()) {
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
    error_log($type. "[". $e->getCode() ."] " . $e->getMessage());
    error_log("in " . $e->getFile() . " @line " . $e->getLine());
    error_log($e->getTraceAsString());
    
    echo "HTTP/1.0 404 Not Found <br />";
    echo "script has been aborted <br />";
    //echo $_SERVER['PHP_SELF'];

    if (!empty($_SERVER['HTTP_REFERER'])) {
        //echo $_SERVER['HTTP_REFERER'];
        echo '<p><a href="'.$_SERVER['HTTP_REFERER'].'">' . htmlUTF8('Back to previous page') . '</a></p>';
    }
    echo '<p><a href="'.$_SERVER['PHP_SELF'].'">' . htmlUTF8('Back to home page') . '</a></p>';
    error_log("exception_handler(HTTP/1.0 404 Not Found)");
    header('HTTP/1.0 404 Not Found');
    exit;
}
function error_handler($errno, $errstr, $errfile, $errline) {
    //throw new fw\fwException($errstr, 0, $errno, $errfile, $errline);
    return false;
}

//error handler function
function customError($errno, $errstr, $errfile, $errline) {
    trace(debug_backtrace());

    switch ($errno) {
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

    $message = '<strong>' . $type . '</strong> : [' . $errno . '] ' . $errstr . '<br />\n' .
        '<strong>' .$errfile. '</strong>@line<strong>' . $errline . '</strong><br />\n' .
        'PHP ' . PHP_VERSION . ' (' . PHP_OS . ')<br />\n' .
        '<strong>Execution of the script has been stopped</strong><br />\n';
    echo $message;
    error_log("$message");                                       //errorlog file
    error_log($message,1,                                      //email to webmaster
        "jp@me.com","From: webmaster@netricite.com");

    /* Ne pas exécuter le gestionnaire interne de PHP */
    return false;  //true to continue
}
