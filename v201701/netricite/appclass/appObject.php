<?php
namespace Netricite\AppClass;

use Netricite\Framework as fw;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\BrowserConsoleHandler;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\ErrorLogHandler;
use Monolog\ErrorHandler;
use Monolog\Processor\IntrospectionProcessor;

/**
 *
 * @author jp
 * @version 201701
 *         
 *          company information is located in config.ini
 */
abstract class appObject
{

    protected $logger;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->initObject();
        // add records to the log
        $this->logger->addDebug('starting(' . get_class($this) . ") ");
    }

    public function initObject()
    {
        // create a log channel
        $this->logger = $this->initLogger(fw\fwConfiguration::get('trace.channel.application'), TRUE);
        
        // add records to the log
        $this->logger->addDEBUG('initObject(' . get_class($this) . ")");
    }

    public function __toString()
    {
        return '__toString(' . get_class($this) . ")";
    }

    function initLogger($channel = "", $introspection = FALSE)
    {
        // create a log channel
        
        /*
         * trace.level.application = DEBUG ; debug, info, notice, warning, error, critical, alert, emergency.
         * trace.level.framework = DEBUG ; debug, info, notice, warning, error, critical, alert, emergency.
         * trace.level.view = DEBUG ; debug, info, notice, warning, error, critical, alert, emergency.
         * trace.level.model = DEBUG ; debug, info, notice, warning, error, critical, alert, emergency.
         * trace.level.controler = DEBUG ; debug, info, notice, warning, error, critical, alert, emergency.
         * trace.channel.application = appl
         * trace.channel.framework = frmk
         * trace.channel.view = view
         * trace.channel.model = modl
         * trace.channel.controler = ctlr
         */
        switch ($channel) {
            case fw\fwConfiguration::get('trace.channel.application'):
                $level = fw\fwConfiguration::get('trace.level.application');
                break;
            case fw\fwConfiguration::get('trace.channel.framework'):
                $level = fw\fwConfiguration::get('trace.level.framework');
                break;
            case fw\fwConfiguration::get('trace.channel.view'):
                $level = fw\fwConfiguration::get('trace.level.view');
                break;
            case fw\fwConfiguration::get('trace.channel.model'):
                $level = fw\fwConfiguration::get('trace.level.model');
                break;
            case fw\fwConfiguration::get('trace.channel.controler'):
                $level = fw\fwConfiguration::get('trace.level.controler');
                break;
            
            default:
                // var_dump($channel);
                $level = "EMERGENCY";
        }
        
        $channel = empty($channel) ? "" : $channel . ".";
        $logger = new Logger($channel . fw\fwConfiguration::get("site.application.name"));
        
        // Instantiate the handlers
        switch ($level) {
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
        if (fw\fwConfiguration::get('trace.streamHandler'))
            $logger->pushHandler($streamHandler);
        if (fw\fwConfiguration::get('trace.browserHandler'))
            $logger->pushHandler($browserHandler);
        if (fw\fwConfiguration::get('trace.firephpHandler'))
            $logger->pushHandler(new FirePHPHandler());
            
            //
            // $errorlogHandler = new ErrorLogHandler();
            // $logger->pushHandler($errorlogHandler); //error_log
            
        // caller's info
        if (fw\fwConfiguration::get("trace.introspection"))
            $logger->pushProcessor(new IntrospectionProcessor("DEBUG"));
            
            // add records to the log
        $logger->addDebug('starting(' . get_class($logger) . ") " . $channel . "/" . $level);
        $logger->addDebug('logs(' . $GLOBALS['site.logs.path'] . ')');
        return $logger;
    }
}
