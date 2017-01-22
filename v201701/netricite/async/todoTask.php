<?php
use Netricite\Framework as fw;
use Netricite\model\Todo as todo;

/**
 * AJAX : purpose: refresh page after class selection
 */

require_once(__DIR__ .  "/asyncEnv.php");

$request = new fw\fwRequest(array_merge($_GET, $_POST));
//refresh page
error_log("Ajax call- todoTask.getRecords");
$mClass = new todo\mTodo();
$records = $mClass->getRecords();

$toReturn = json_encode($records);
echo $toReturn;
