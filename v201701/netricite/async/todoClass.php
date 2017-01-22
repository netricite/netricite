<?php
use Netricite\Model\Todo as todo;

/**
 * AJAX : purpose: get the list of items id separated by coma (,)
 */ 

require_once(__DIR__ .  "/asyncEnv.php");

$mClass = new todo\mTodo();
error_log("todo POST" . json_encode($_POST)  );
$list_order = $_POST['list_order'];
// convert the string list to an array
$list = explode(',' , $list_order);
$i = 1 ;
error_log("todo list" . json_encode($list)  );

foreach($list as $id) {
    try {
        //info( $id . "/" . $i . " updated");
        error_log("todoClass(" . $id . "/" . $i . ") updated");
        $mClass->updateOrder($id, $i);
    } catch (PDOException $e) {
        echo 'PDOException : '.  $e->getMessage();
    }
    $i++ ;
}
