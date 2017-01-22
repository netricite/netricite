<?php
use Netricite\Framework as fw;

use Netricite\Model\Chat as chat;

/**
 * AJAX : purpose: reset the status(0) of the messages
 */

require_once(__DIR__ .  "/asyncEnv.php");

$mChat = new chat\mChat();
if (isset($_SESSION["pseudo"])) {
    /*
     * the session is opened
     */
    $json['count'] = $mChat->count($_SESSION["pseudo"]);
    
    if ($json['count'] > 0) {
        /* 
         * get new messages and change status
         */
        $records = $mChat->get($_SESSION["pseudo"], 1);
        /*
         * change status of the message
         */
        foreach ($records as $record) :
            $mChat->updateStatus($record['id'], 0);
        endforeach
        ;
    }
    
    /*
     * success
     */
    $json['error'] = '0';
    
} else {
    /*
     * the session is not opened
     */
    $json['count'] = 0;
    $json['error'] = '1';
}

/*
 * return encoded $json array
 */
echo json_encode($json);
