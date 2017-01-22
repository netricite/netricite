<?php
//form generator init
use Netricite\Framework as fw;
$this->formgen = new fw\fwFormGen();

//variables init
/*
$date = date('Y-m-d H:i:s');
*/
if(isset($_SESSION['userid'])){
    $user = $_SESSION['pseudo'];
} else $user ="not registered";

?>