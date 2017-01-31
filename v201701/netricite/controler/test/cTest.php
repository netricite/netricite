<?php
namespace  Netricite\Controler\Test;

use Netricite\Framework as fw;
use Netricite\Model\Todo as todo;
use Netricite\Payment as payment;

/**
 * @author jp
 * @version 2016-14
 *
 * Application controler
 */
class cTest extends fw\fwControlerSession {         //session tpe : without login

  /**
   * constructor
   */
  public function __construct() {
  	parent::__construct(); 
  }

  /**
   * refresh TEST page
   */
  public function test() {
      $this->logger->addDebug(".test", debug_backtrace());
      //send mail
      // Send the message to the user
      $token="notoken";
      $email = $_POST['data']['email'];
      $subject = "Thank You For Registering!";
      $message = "Thank you for registering at our site!\n\n";
      $message.= "You can login from this URL:\n";
      $message.= get_page_url()."?token=".$token."\n\n";
      $message.= "The link is going expire automatically after 10 minutes.";
      $fromEmail = 'noreply@'.$_SERVER['SERVER_NAME'];
      $result = send_email($message, $_POST['email'], $subject, $fromEmail);
      /*
       * redirect to home page
       */
      
      
      $this->redirect("test","test");
  }
  
  /**
   * Booking
   */
  public function booking() {
      $this->logger->addDebug(".booking", debug_backtrace());
        
      //ADD a TODO TASK
      $data=array("title"=>"Réservation fondue",
          "milestone"=>date('Y-m-d H:i:s'),
          "note" =>"une note",
          "class"=> "BOOKING",
          "user"=>"jp",
          "status"=> "0",
          "itemorder"=> "0",
      );
      $_POST['data']= $data;

      $class = new todo\mTodo();
      $class->save($_POST['data']);
      //REFRESH PAGE
      $this->redirect("shop","shop");
   }
   
   /**
    * upload file
    */
   public function upload() {
       $this->logger->addDebug(".upload", debug_backtrace());
       if (empty($_FILES)) throw new \Exception("no selected file");
       //$target_dir = "D:/wamp/www/download/img/";
       
       //subsitute non ISO characters
       $filename = preg_replace('/([^.a-z0-9]+)/i', '-', basename($_FILES["fileToUpload"]["name"]));    
       $output = $GLOBALS["site.download.path"] . $filename;
       appWatch(array("input file"=>$_FILES["fileToUpload"],"output file"=>$output),"", get_class($this));
       
       parent::uploadFile($output);
   }
   
   public function captcha() {
       $this->logger->addDebug(json_encode($_POST), debug_backtrace());
       if(isset($_POST["g-recaptcha-response"])) {
       
           $data = array ('secret' => $GLOBALS['google.secretkey.recaptcha'],
               'response' => $_POST["g-recaptcha-response"],
               'remoteip'=>$_SERVER['REMOTE_ADDR']
           );
           
           $data = http_build_query($data);            //return http_build_query($data, '', '&');
       
           $context_options = array (
               'http' => array (
                   'method' => 'POST',
                   'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
                   . "Content-Length: " . strlen($data) . "\r\n",
                   'content' => $data
               )
           );
           
           $context = stream_context_create($context_options);
           $response=json_decode( file_get_contents(fw\fwConfiguration::get('google.recaptcha.verify'), false, $context), true );

           
           if( !empty($response)  && $response["success"] ) {
               //processing registration
               echo '<h2>sucess full captcha</h2>';
               }
           } else {
               info("E", "invalid recaptcha");                       //error message
               if(!empty($response)) {
                   echo '<h2>captcha error, Something went wrong</h2>';
                   echo '<p>The following error was returned:';
                   $list= empty($response["error-codes"] ) ? $response : $response["error-codes"] ;
                   //$list=$response;
                   foreach ($list as $name => $value) {
                       echo '<p>' , $name , ' = ';
                       echo ' ' , $value , '</p> ';
                   }
                   echo '</p>';
               } else echo '<h2>Invalid captcha </h2>';
           }
   }
   
}