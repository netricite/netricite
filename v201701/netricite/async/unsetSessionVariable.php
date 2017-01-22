<?php
/**
 * Called by Ajax in a JS function
 */
use Netricite\Framework as fw;

require_once("asyncEnv.php"); 

/*
 * unset session variable
 * 
 */
watch($_POST,"unsetSessionVar.parameters:" );
$request = new fw\fwRequest(array_merge($_GET, $_POST));
$var=$request->getParameter("variable");
//error_log("usunsetSessionVar.parameter:" . $var );
$session=$request->getSession();
//error_log("usunsetSessionVar.value:" . $session->get($var) );
$session->clearSession($var);