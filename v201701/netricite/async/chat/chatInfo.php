<?php
/**
 * Ajax script
 */

require_once(__DIR__ .  "/asyncEnv.php");

$today = date("F j, Y, g:i a");

$json['error'] = '0';
$json['info'] = $_POST['message'] . $today;

echo $_POST['message'] . $today;

