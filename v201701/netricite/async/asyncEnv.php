<?php
use Netricite\Framework as fw;

error_log("Ajax - environment");
error_log("Ajax - (__FILE__) full path and file name: " . __FILE__) ;
error_log("Ajax - (__DIR__) full path without filename: " . __DIR__ );
error_log("Ajax - (basename(__FILE__)) = filename: " . basename(__FILE__)) ;
error_log("Ajax - server.document_root) physical path root (d:/wamp/www): " . $_SERVER['DOCUMENT_ROOT']);
error_log("Ajax - ( dirname(__FILE__)) current path: " . dirname(__FILE__));
//[07-Jan-2017 09:46:55 Europe/Paris] Ajax - ( dirname(__FILE__).'/file.php') include path: D:\wamp\www\netricite\v2016-14\netricite\async/file.php

$rootpath = realpath(__DIR__ . '/../..') ."/";
error_log("asyncEnv.php - root path: " . $rootpath);
/*
 * application constants
 */
const EXTENSION = ".ini";
define ("DEV" , $rootpath . "dev" . EXTENSION);
define ("PROD" , $rootpath . "prod" . EXTENSION);

require $rootpath."netricite/framework/fwBootstrap.php";

$session = new fw\fwSession();                          //session starts

error_log("AJAX - asyncEnv.php completed with success");
?>