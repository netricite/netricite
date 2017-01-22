<?php

use Netricite\Framework as fw;

/**
 * Debug helpers
 *
 * @author jp
 * @version 2016-1
 *
 *
 */

/*
 * Initialize DEBUG
 */
$start_time = microtime(true);

/*
 * invoked when exit
 */
register_shutdown_function('stopTrace');


/**
 * start trace in php_error.log in wampserver
 */
function startTrace()
{
    global $debug;
    global $debug_trace;
    global $debug_framework;
    $debug = fw\fwConfiguration::get("debug");
    $debug_trace=fw\fwConfiguration::get("debug.trace");;
    $debug_framework=fw\fwConfiguration::get("debug.framework");;
    $status ="";
    $status = ($debug) ? "DEBUG(ON)":"DEBUG(OFF)";
    $status .= ($debug_trace) ? " TRACE(ON)":" TRACE(OFF)";
    $status .= ($debug_framework) ? " FRAMEWORK(ON)":" FRAMEWORK(OFF)";
    error_log("************** new http request - ". $status ." **");
    
}

/**
 * trace function to be called at the begining of a function
 * 
 * @param array $trace provided by debug_backtrace()
 * @param string $query sql query 
 */
function trace($trace, $info = null)
{
    appTrace($trace,$info);
}

function appTrace($trace, $data=null, $infotext = null)
{
    global $debug;
    global $debug_trace;
    global $debug_framework;
    if ($debug=="1" && $debug_trace=="1") {
        $data= empty($data) ? $_POST : $data;
        $log=basicLog($trace, $data, $infotext);
    }
}
function fwTrace($trace, $data=null, $infotext = null)
{
    global $debug;
    global $debug_trace;
    global $debug_framework;
    if ($debug=="1" && $debug_trace=="1" && $debug_framework=="1") {
        $data= ($data==null) ? $_POST : $data;
        $log=basicLog($trace, $data, $infotext);
    }
}
function basicLog($trace, $data, $infotext = null) {
    //var_dump($data);
    $caller = array_shift($trace);
    $log = "@Trace-";
    $relativeClass = "";
    if (!empty($caller['class'])) {
        $members = explode(".", str_replace('\\', '.', $caller['class']));
        $name = array_shift($members);
        //manage relative class
        foreach ($members as $member) {
            $relativeClass .= $member . "/";
        }
    }
    $log .= substr($relativeClass,0,strlen($relativeClass)-1) . ".";
    if (isset($caller['function'])) $log = $log . $caller['function'];
    if (isset($caller['file']))  $log = $log . " In file(" . $caller['file'] . ") ";
    if (isset($caller['line']))  $log = $log . " @line(" . $caller['line'] . ") ";
    error_log($log);

    // display complementary data if any
    if (!empty($data)) {
        if(is_array($data))
            $data=json_encode($data);
        error_log("@Trace@data(". $data . ")");
    }

    // display complementary info if any
    if (!empty($infotext))  error_log("@Trace@info: " . $infotext);
}

/**
 * log the content of an array
 * 
 * @param array $info watch values
 * @param string $message additional information
 */
function watch($data, $infotext = null)
{
global $debug;
    global $debug;
    $log="";
    if ($debug=="1") {
        $log = " --->@application.watch: ";
        if (isset($data)) $log .= is_array($data) ? json_encode($data) : $data;
        error_log($infotext . " / " . $log);
    }
}
/**
 * errorlog watch application variable
 * 
 * @param array $info watch values
 * @param string $message additional information
 * @param string $caller
 */
function appWatch($data, $infotext = null, $caller="app")
{
    global $debug;
    global $debug_trace;    
    global $debug_framework;
    if ($debug=="1") {
        $log="";
        if (isset($data)) $log = is_array($data) ? json_encode($data) : $data;
        app_error_log($caller, $log, $infotext);
    }
}
/**
 * errorlog watch framework variable
 * 
 * @param array $info watch values
 * @param string $message additional information
 * @param string $caller
 */
function fwWatch($data, $infotext = null, $caller="fwFramework")
{
    global $debug;
    global $debug_trace;    
    global $debug_framework;
    if ($debug_framework=="1") {
        $log="";
        if (isset($data)) $log = is_array($data) ? json_encode($data) : $data;
        app_error_log($caller, $log, $infotext);
    }
}

function app_error_log($caller, $log, $infotext) {
    global $debug;
    global $debug_trace;
    global $debug_framework;

    $name=getApplicationClass($caller);
    $log = " --->@watch(". getApplicationClass($caller) . "." . $log;
    // display sql statement if any
    if (!empty($infotext))  $log.=" @info: " . $infotext;
    
    error_log($log);
}

/**
 * stop trace routine invoked automatically by register_shutdown_function
 */
function stopTrace()
{
    global $debug;
    if ($debug=="1") {
        global $start_time;
        error_log("----------------------------------------------------");
        error_log("*** Execution took: " . round((microtime(true) - $start_time), 4) . " seconds.");
        error_log("----------------------------------------------------");
    }
}



/**
 * return class of the object
 *
 */
function getApplicationClass($class)
{
    //check if Fully Qualified Class Name
    $members = explode(".", str_replace('\\', '.', $class));
    if (count($members) > 1) {
        //manage relative class
        $relativeClass =  substr($members[count($members) - 1], 0);      // extract root class from fully qualified class
    } else {
        $relativeClass = $class;
    }
    //var_dump("caller class(" . $relativeClass .")");
    return $relativeClass;
}

