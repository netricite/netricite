<?php
use Netricite\Framework\fwRouter;

/*
 * application constants
 */
error_log("*********** index.php ************************** starting");
const PATH_INI_FILE = "";
const EXTENSION = ".ini";
define ("DEV" , realpath(__DIR__) . "/dev" . EXTENSION);
define ("PROD" , realpath(__DIR__) . "/prod" . EXTENSION);

$rootpath = realpath(__DIR__) ."/";
error_log("index.php - base directory: " . $rootpath);

require "/netricite/framework/fwBootstrap.php";

try {
    /*
     * route the http request to the ad-hoc controler
     */
    $router = new fwRouter();
    $router->routeRequest();
} catch (\Exception $e) {
    throw new \Exception($e->getMessage());
}
error_log("*********** index.php ************************** completed");