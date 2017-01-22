<?php
/**
 * Called by Ajax in a JS function
 */
use Netricite\Framework as fw;

require_once("asyncEnv.php"); 

/**
 * set session variable
 * 
 */

//session starts
$request = new fw\fwRequest(array_merge($_GET, $_POST));
watch( $request, "setSessionVariable(POST)"  );

$var=$request->getParameter("variable");
error_log("setSessionVariable.parameter(var):" . $var );

$val=$request->getParameter("value");
error_log("setSessionVariable.parameter(val):" . $val );

//set session variable
$_SESSION [$var]=$val;

//unset action to prevent refresh page with parameters
unset($_POST['action']);                //delete action url parameter (for refresh page purpose)
watch( $_SESSION, "setSessionVariable(_SESSION)"  );