<?php
/**
 * Called by vTemplate(onSignIn(googleUser) script) via AJAX
 */
use Netricite\Framework as fw;
use Netricite\Model\Login as login;
//load configuration env.
require("asyncEnv.php"); 
$profile=$_POST["profile"];
watch($_POST,"asyncGoogleLogin(parameters)" );
$name = explode("@", $profile["email"]);

//Get user by email given GOOGLE
$user = new login\mUser();
$record=$user->getRecord($profile["email"],"email");
if (empty($record[0])) {
    $data=array("pseudo"=>$name[0], "email"=>$profile["email"], "firstname"=>$profile["givenname"], "lastname"=>$profile["familyname"],);
    //create a record using the email info
    $user->save($data);
    
    $_SESSION['pseudo'] = $profile["email"];
    $_SESSION['userid'] = $user->id;
} else {
    //user already exists
    $_SESSION['pseudo'] = $record['pseudo'];
    $_SESSION['userid'] = $record['id'];
}
$_SESSION['img'] = $profile["img"];
watch( $_SESSION, "asyncGoogleLogin(session)"  );