<?php
use Netricite\Framework as fw;
// Use Namespaced classes
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\BrowserConsoleHandler;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\ErrorLogHandler;
use Monolog\ErrorHandler;
use Monolog\Processor\IntrospectionProcessor;

/*
 * general helpers function
 *
 * @author jp
 * @version 2016-13
 *
 * 2016-13 htmlutf8 text conversion
 * 2016-13 sendmail with parameters
 * 2016-14 redirect with parameters
 * 2016-14 get_page_url with parameters
 * 2016-14 htmlutf8 with parameters
 *
 */

/**
 * helper: autoload classfile.php on new
 *
 * @param string $class_name            
 * @throws fwException
 *
 * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md
 */
function classAutoLoader($class)
{
    // watch("I-fwHelpers.classAutoLoader(load):" . $class);
    /*
     * helper: replace the namespace separators with directory separators
     * append with .php
     */
    // $root=$GLOBALS["documentRoot"];
    $classFile = $GLOBALS["application.path"] . str_replace('\\', '/', $class) . '.php';
    
    // if the file exists, require it
    if (is_readable($classFile)) {
        require $classFile;
    } else {
        watch("W-fwHelpers.classAutoLoader(class not loaded):" . $class);
        // throw new \Exception("fwHelpers.classAutoLoader unable to load $classFile");
    }
}
// end classAutoLoader

/**
 * initlogger
 */
function initLogger($channel)
{
    // watch("logger: " . fw\fwConfiguration::get('trace.channel.application') . "." . fw\fwConfiguration::get("site.application.name"));
    // watch("Monolog/logger: " . $channel . "." . fw\fwConfiguration::get("site.application.name"));
    global $logger;
    // create a log channel
    $logger = new Logger($channel . "." . fw\fwConfiguration::get("site.application.name"));
    // Instantiate the handlers
    
    switch (fw\fwConfiguration::get('trace.level.helper')) {
        case "DEBUG":
            $streamHandler = new StreamHandler($GLOBALS['site.logs.path'], Logger::DEBUG, TRUE);
            $browserHandler = new BrowserConsoleHandler(Logger::DEBUG, TRUE);
            break;
        case "INFO":
            $streamHandler = new StreamHandler($GLOBALS['site.logs.path'], Logger::INFO, TRUE);
            $browserHandler = new BrowserConsoleHandler(Logger::INFO, TRUE);
            break;
        case "NOTICE":
            $streamHandler = new StreamHandler($GLOBALS['site.logs.path'], Logger::NOTICE, TRUE);
            $browserHandler = new BrowserConsoleHandler(Logger::NOTICE, TRUE);
            break;
        case "WARNING":
            $streamHandler = new StreamHandler($GLOBALS['site.logs.path'], Logger::WARNING, TRUE);
            $browserHandler = new BrowserConsoleHandler(Logger::WARNING, TRUE);
            break;
        case "CRITICAL":
            $streamHandler = new StreamHandler($GLOBALS['site.logs.path'], Logger::CRITICAL, TRUE);
            $browserHandler = new BrowserConsoleHandler(Logger::CRITICAL, TRUE);
            break;
        
        default:
            $streamHandler = new StreamHandler($GLOBALS['site.logs.path'], Logger::EMERGENCY, TRUE);
            $browserHandler = new BrowserConsoleHandler(Logger::EMERGENCY, TRUE);
    }
    
    // Push a stack of handlers
    // Push a stack of handlers
    if (fw\fwConfiguration::get('trace.streamHandler'))
        $logger->pushHandler($streamHandler);
    if (fw\fwConfiguration::get('trace.browserHandler'))
        $logger->pushHandler($browserHandler);
    if (fw\fwConfiguration::get('trace.firephpHandler'))
        $logger->pushHandler(new FirePHPHandler());
        // $errorlogHandler = new ErrorLogHandler(); //error_log
        // $logger->pushHandler($errorlogHandler); //error_log
        
    // caller's info
        // if ($Introspection) $logger->pushProcessor(new IntrospectionProcessor("DEBUG"));
    $logger->addDebug('starting(' . get_class($logger) . ") " . $channel . "/" . fw\fwConfiguration::get('trace.level.helper'));
    $logger->addDebug('logs(' . $GLOBALS['site.logs.path'] . ')');
    return $logger;
}

/**
 * rotate php_error.log
 * the errorlog filename include the current date
 */
function rotateLog()
{
    ini_set('error_log', $_SERVER['DOCUMENT_ROOT'] . "logs/php_error." . date('Y-m-d') . ".log");
}

/**
 * path information
 */
function baseDirectory()
{
    global $logger;
    $logger->addDebug("Base - vTemplate.php");
    $logger->addDebug("Base - (__FILE__) full path and file name: " . __FILE__);
    $logger->addDebug("Base - (__DIR__) full path without filename: " . __DIR__);
    $logger->addDebug("Base - (basename(__FILE__)) = filename: " . basename(__FILE__));
    $logger->addDebug("Base - server.document_root) physical path root (d:/wamp/www): " . $_SERVER['DOCUMENT_ROOT']);
    $logger->addDebug("Base - ( dirname(__FILE__).'/file.php') include path: " . dirname(__FILE__) . '/myFileExample.php');
}

/**
 * helper: display the error to user
 *
 * @param string $message            
 */
function errorMessage($message)
{
    $view = new fw\fwView("error");
    $view->display(array(
        'errorMessage' => $message
    ));
}

/**
 * helper: js alert box
 *
 * @param string $message            
 */
function alert($message)
{
    echo "<script type='text/javascript'>alert('$message');</script>";
}

/**
 * fill $_SESSION['info']
 *
 * @param string $severity            
 * @param string $message            
 */
function info($severity, $message)
{
    $_SESSION['info'] = date("Y-m-d H:i:s") . "</br>" . "%$severity" . "-" . $message;
}

/**
 * helper : convert a string date to mysql timestamp
 *
 * @param string $dateString            
 *
 */
function convertDate($dateString)
{
    return date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $dateString)));
}

/**
 * helper: sendmail
 *
 * @param string $class_name            
 * @throws fwException
 *
 * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md
 */
function sendmail($messageText, $to = "jpguilleron@hotmail.com", $subject = "Copy Chat sent by eMail", $from, $cc)
{
    global $logger;
    $mail = fw\fwConfiguration::get("company.email"); // from dev.ini
    
    $from = ! empty($from) ? $from : $mail;
    $headers = "From: " . $from . "\r\n";
    
    $cc = empty($cc) ? "" : "CC: " . $cc . "\r\n";
    $headers .= $cc;
    $headers .= "CC: " . $mail . " \r\n";
    $headers .= "Reply-to: \"Client\" <" . $from . ">" . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n" . "Content-type: text/html; charset=UTF-8" . "\r\n";
    
    // use wordwrap() if lines are longer than 70 characters
    $txt = wordwrap($messageText, 70);
    
    $logger->addNotice("fwHelpers.sendmail, mail sent: " . $to . " " . $subject . " " . $txt . " " . $headers);
    mail($to, $subject, $txt, $headers);
}
// end sendmail

/**
 * Helper: Convert text to utf-8
 *
 * @param string $text            
 */
function htmlutf8($text)
{
    // htmlspecialchars Convert special characters in HTML entity like '&' to '&amp;' ; '"' to 'quot;' etc
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false);
}

/**
 * Helper: cleanup value inserted in a HTML page
 *
 * @param string $text            
 * @return string
 */
function htmlCleanup($text)
{
    // nl2br(). convert carriage return to HTML <br />
    return nl2br(htmlutf8($text));
}

/**
 * Helper: redirect to page url
 *
 * @param string $url            
 */
function redirect($url)
{
    global $logger;
    $logger->addInfo("fwHelpers.redirect " . $url);
    header("Location: $url");
    exit();
}

/**
 * Helper: redirect to page url
 *
 * @param string $url            
 */
function redirectError()
{
    global $logger;
    $logger->addDebug("redirectError", debug_backtrace());
    echo "HTTP/1.0 404 Not Found <br />";
    echo "script has been aborted <br />";
    header('HTTP/1.0 404 Not Found');
    exit();
}

/**
 * Helper: Find out the URL of the current PHP file
 *
 * @return string url
 */
function get_current_url()
{
    global $logger;
    // Find out the URL of a PHP file
    $url = 'http' . (empty($_SERVER['HTTPS']) ? '' : 's') . '://' . $_SERVER['SERVER_NAME'];
    /*
     * if(!empty($_SERVER['REQUEST_URI']) ){
     * $url.= $_SERVER['REQUEST_URI'];
     * }
     * else{
     * $url.= $_SERVER['PATH_INFO'];
     * }
     */
    $url .= ! empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_SERVER['PATH_INFO'];
    $logger->addDebug("get_page_url(" . $url . ")");
    return $url;
}

/**
 * Helper; Generate random token
 *
 * @param integer $length            
 * @return string
 */
function generateToken($text, $length)
{
    global $logger;
    $key = $text . "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN-";
    $token = substr(str_shuffle(str_repeat($key, $length)), 0, $length);
    $logger->addInfo("fwHelpers.generateToken.token(" . $token) . ")";
    return $token;
}

/*
 * 
// The number of login attempts for the last 10 minutes by this IP address
    CREATE TABLE IF NOT EXISTS `reg_login_attempt` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `ip` int(11) unsigned NOT NULL,
      `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
      `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
  
	$count_10_min =  ORM::for_table('reg_login_attempt')
					->where('ip', sprintf("%u", ip2long($ip)))
					->where_raw("ts > SUBTIME(NOW(),'0:10')")
					->count();
 * 
 */
