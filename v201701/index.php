<?php
use Netricite\Framework as fw;

/*
 * application constants
 */
error_log("*********** index.php **************************");
const PATH_INI_FILE = "";
const EXTENSION = ".ini";
define ("DEV" , realpath(__DIR__) . "/dev" . EXTENSION);
define ("PROD" , realpath(__DIR__) . "/prod" . EXTENSION);

$rootpath = realpath(__DIR__) ."/";
error_log("index.php - root path: " . $rootpath);

require "/netricite/framework/fwIndex.php";

try {
    /*
     * route the http request to the ad-hoc controler
     */
    $router = new fw\fwRouter();
    $router->routeRequest();
} catch (\Exception $e) {
    throw new \Exception($e->getMessage());
}
error_log("*********** index.php ************************** completed");