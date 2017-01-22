<?php
/**
 * Called by Ajax in a JS function
 * purpose: update the status of the user 
 */
use Netricite\Framework as fw;
use Netricite\Model\Login as login;

require_once("../asyncEnv.php"); 

/*
 * unset session variable
 * 
 */
error_log("chatStatus.parameters:" . var_dump($_POST ));
$status=$_POST["status"];
// update user status
$model = new login\mUser();
$model->updateStatus($_SESSION['userid'], $var);
