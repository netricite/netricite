<?php
namespace Netricite\Framework;

use Netricite\Framework as fw;

/**
 * @author jp
 * @version 2016-14
 * 
 * configuration parameter management
 * application.ini (dev.ini or prod.ini) file is located in resource/configuration/
 * DEV and PROD constants are definied in index.php
 * 
 */
class fwConfigLanguage 
{
    /**
     * list of configuration parameters
     */
    private static $config;
    
    /**
     * load params from array (inifile)
     */
    public function __construct($params)
    {
        parent::__construct();
        fwTrace(debug_backtrace(), $params);
        self::$config=$params;
    }
    
    
    /**
     * get configuration parameter
     *
     * @param string $param  configuration parameter
     * @param string $defaultValue  default value if the parameter is not found
     * @return string the value of the parameter
     */
    public static function get( $param,  $defaultValue = null)
    {
        if (empty(self::$config)) self::getConfig();
        if (isset(self::$config[$param])) {
            $value = self::$config[$param];
        } else {
            $value = empty($defaultValue) ? $param : $defaultValue;
            //fwWatch(array("get(param unknown)"=>$param), "", get_class());
        }
        return $value;
    }
   
    /**
     * initialize configuration parameters if needed
     *
     * @return string return array of configuration parameters
     */
    public static function getConfig($langfile="")
    {
        if (empty(self::$config)) {
            fwTrace(debug_backtrace());

            if (empty($langfile)) {
                $path=fw\fwConfiguration::get('site.language.path');     //"public/language/";
                $langfile= file_exists($langfile) ? $langfile : $path . $_SESSION['lang']. ".ini";
            }
            /*
             * get .ini file
             */
            if (! file_exists($langfile)) {
                self::$config=array("lang file"=>"empty, use default provided by the form");
                //throw new \Exception("config file ($langfile) not found");
            } else {
                self::$config = parse_ini_file($langfile);                  //get config
            }
            fwWatch(self::$config, $langfile, get_class());

        }
        return self::$config;
    }
    
}