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
class fwConfiguration {
    /** 
     * list of configuration parameters 
     */
    private static $config;         
    
    /**
     * load params from array (inifile)
     */
    public function __construct($params)
    {
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
        if (isset(self::$config[$param])) {
            $value = self::$config[$param];
            fwWatch(array("key"=>$param, "value"=>$value), ".get", get_class());
        } else {
            $value = empty($defaultValue) ? $param : $defaultValue;
            fwWatch(array("key unknown"=>$param), ".get", get_class());
        }
        return $value;
    }
    
    public static function getConfigClass( $class)
    {
        $config=array();
        foreach( self::$config as $key => $value ) {
            $members=explode(".", $key);
            if ($members[0]==$class) {
                //found the class
                array_push($config,$key . "=>". $value);
            }
            
        }
        fwWatch($config, ".getConfigClass", get_class());
        return $config;
    }
    
    /**
     * initialize configuration parameters if needed
     *
     * @return string|mixed return array of configuration parameters
     */
    public static function getConfig($inifile="")
    {
        if (empty(self::$config)) {
            if (empty($inifile)) {
                // get configuration params from config PROD file
                $inifile = $GLOBALS["application.root.path"] . PROD;
    
                if (! file_exists($inifile)) {
                    // get configuration params from config DEV file
                    $inifile = $GLOBALS["application.root.path"] . DEV;
                }
            }
    
            /*
             * get .ini file
             */
            if (! file_exists($inifile)) {
                throw new fw\fwException("config file ($inifile) not found");
            } else {
                self::$config = parse_ini_file($inifile);
                fwWatch(self::$config, $inifile, get_class());
            }
        }
        return self::$config;
    }
}