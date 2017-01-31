<?php
use Netricite\Framework as fw;
use Netricite\Controler\Shop as shop;

/**
 * AJAX : purpose: refresh page after class selection
 */

require_once (__DIR__ . "/asyncEnv.php");

$request = new fw\fwRequest(array_merge($_GET, $_POST));
// refresh page
error_log("Ajax call- cartAdd");
$cClass = new shop\cCart();
$returnCode = $cClass->add();
error_log("Ajax call- cartAdd - completed");
error_log("cartAdd " . json_encode($returnCode));
error_log("Ajax call- cartAdd - return");
echo json_encode($returnCode);
