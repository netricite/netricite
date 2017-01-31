<?php
namespace  Netricite\Controler\Login;

use Netricite\Framework as fw;
use Netricite\Model\Login as login;


/**
 * controler of the registration view
 *
 * @author jp
 * @version 2016-14 confirmation link and token management
 *
 */
/*
DESIGN confirmation link registration
=====================================
Phase 1 - Registration
call(vGeneration.php?action=register)
	oUser.get($_POST[email])
	oUser.resetToken() 

Phase 2 - Registration
link callback(vGeneration.php?action=token,token='token') 
	oUser.get($_POST.token)
	exists (oUser.dateToken<date.now+10 minutes)  oUser.setActive
	else - oUser.resetToken()

function resetToken() 
	oUser.token=generateToken(oUser.email)
	oUser.tokenDate=date.now
	oUser.status=inactive
	oUser.save()
	sendMail(oUser.email,'link to register')
	redirect(index.php)

function setActive() 
	oUser.token=generateToken(oUser.email)
	oUser.tokenDate=date.now
	oUser.status=active
	oUser.date_created=date.now
	oUser.save()
	sendMail(oUser.email,'confirmation')
	redirect(index.php)
 * 
 */
class cRegistration extends fw\fwControlerSession{
   	
    /**
     * constructor
     */
    public function __construct(){
        parent::__construct();							
        $this->model = new login\mUser();
    }

    /**
     * Get application data
     * {@inheritDoc}
     * @see \Netricite\Framework\fwControler::getAppData()
     * @return array of application data
     */
    public function getAppData() {
        //get user information
        $appdata=$this->getRecord($_SESSION['userid']);
        if (empty($data))
            $appdata= array("email"=>"", "pseudo"=>"", "pwd"=>"",
                "passwordConfirm"=>"", "lastname"=>"", "firstname"=>"", "language"=>"FR", "gender"=>"F",
                "phone"=>"", "address"=>"", "city"=>"", "country"=>"France", "zipcode"=>"", "birthdate"=>"");
        return $appdata;
    }
    /**
     * manage registration action
     * 
     */
    //const SITE_VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';
    public function registration(){
        //appTrace(debug_backtrace());
        $this->logger->addDebug('registration' , debug_backtrace());
        if(isset($_POST["g-recaptcha-response"])) {

            $data = array ('secret' => $GLOBALS['google.secretkey.recaptcha'], 
                            'response' => $_POST["g-recaptcha-response"],
                            'remoteip'=>$_SERVER['REMOTE_ADDR']
            );
            //appWatch($data,"g-recaptcha-verify",get_class($this));
            $this->logger->addInfo('g-recaptcha-verify' , $data);
            $data = http_build_query($data);            //return http_build_query($data, '', '&');
            
            $context_options = array (
                'http' => array (
                    'method' => 'POST',
                    'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
                    . "Content-Length: " . strlen($data) . "\r\n",
                    'content' => $data
                )
            );
            //appWatch($data,"g-recaptcha-request",get_class($this));
            $this->logger->addInfo('g-recaptcha-request' , $data);
            $context = stream_context_create($context_options);
            $response=json_decode( file_get_contents(fw\fwConfiguration::get('google.recaptcha.verify'), false, $context), true );
            
            //$captcha=$_POST["g-recaptcha-response"];
            //$response=json_decode(file_get_contents(
            //    "https://www.google.com/recaptcha/api/siteverify?secret=".$GLOBALS['google.secretkey.recaptcha']."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']
            //    ),TRUE);       
            //appTrace(debug_backtrace(),$response);
            $this->logger->addInfo('g-recaptcha-response' , $response);
            if( !empty($response)  && $response["success"] ) {
                //processing registration
                unset($_POST['data']['passwordConfirm']);                   //not saved
                if (empty($this->getRecord($_POST['data']['pseudo'], "pseudo"))) {
                    info("I", "recaptcha confirmed");                       //ok message
                    $this->sendConfirm($_POST['data']);
                } else {
                    info("w", htmlutf8("pseudo déjà utilisé"));  //error message
                    $this->generateView(array('errorMessage' => htmlutf8('pseudo déjà utilisé')), "index");
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

        } else {
            echo '<h2>captcha is mandatory.</h2>';
            info("W", "captcha is mandatory");                       //warning message
        }
      } 
      
      /**
       * manage token action
       *
       */
      public function confirm(){
          try {
              //appTrace(debug_backtrace(), $this->request->parameters);
              $this->logger->addDebug(json_encode($this->request->parameters) , debug_backtrace());
                
              if (empty($this->request->parameters)) throw new \Exception(get_class($this) . " invalid callback token" );
              $conditions="token='" .$this->request->getParameter('token'). "' AND tokenExpiry > NOW() AND status=0";      
              if (empty($this->get(array("conditions"=>$conditions)))) throw new \Exception(get_class($this) ." unable to get valid token");
              $this->setActive($this->record[0]);
              /*
               * redirect to home page
               */
              info("I", "registration confirmed");
              $this->redirect("root", "root");
          } catch (\Exception $e) {
              //appWatch($this->request->parameters, "confirm(url.paramaters)" . $e->getMessage(),get_class($this));
              $this->logger->addError(json_encode($this->request->parameters) , $e->getMessage());
              info("F", "invalid token, operation aborted please reset");  //error message
              redirectError();
          }
      }
      /*
      function setActive()
          oUser.tokenDate=date.now
          oUser.status=active
          oUser.date_created=date.now
          oUser.save()
          sendMail(oUser.email,'confirmation')
          redirect(index.php)
      */
      /**
       * setActive
       *
       */
      public function setActive($record){
          try {
              //appTrace(debug_backtrace(), $record);
              $this->logger->addDebug(json_encode($record) , debug_backtrace());
              
              if (empty($record)) throw new \Exception(get_class($this) . " unable to change status" );
              
              //save user data
              $id=$record['id'];
              $email=$record['email'];
              
              //update user data
              $record=array();                                           //reset record
              $record['id']=$id;                                         //current id
              $record['status']=1;                                       //status active
              $record['date_created']=date('Y-m-d H:i:s');               //today
              $record['tokenexpiry']=$record['date_created'];            //cannot execute twice
              $record['token']=null;                                     //empty
              if (!$this->saveData($record)) throw new \Exception(get_class($this) ." unable to record data");
              
              //send confirmation mail to the user
              $subject = "Thank You For Registering!";
              $message = "You are now registered\n\n";
              $message = "You can access our services on our web page\n\n";
              $message.= "Hope you'll enjoy our web site.". "\n\n";
              $message.= "Your webmaster". "\n\n";
              $fromEmail = 'noreply@'.$_SERVER['SERVER_NAME'];
              sendmail($message,$email, $subject, $fromEmail);
              info("I", "new account activated");
              $this->logger->addInfo("new account activated: " . $email);
          } catch (\Exception $e) {
              //appWatch($record, "setActive()" . $e->getMessage(),get_class($this));
              $this->logger->addError(json_encode($record) , $e->getMessage());
              info("F", "cannot activate user");                //error message
          }
      }
      /*
      function resetToken()
      oUser.token=generateToken(oUser.email)
      oUser.tokenDate=date.now
      oUser.status=inactive
      oUser.save()
      sendMail(oUser.email,'link to register')
      redirect(index.php)
      */
     /**
      * resetToken
      * 
      * @param array $user
      * @throws \Exception
      */
      public function sendConfirm($user){
          try {
              //appTrace(debug_backtrace(), $user);
              $this->logger->addDebug($user , debug_backtrace());
              
              if (empty($user)) throw new \Exception(get_class($this) . " unable to resetToken" );
              $user['status']=0;                        //status inactive
              $email=$user['email'];
              $token=generateToken($email,128);
              $user['token']=$token;                    //new token
              $dateExpiry = date('Y-m-d H:i:s',strtotime("+10 minutes"));
              $user['tokenexpiry']=$dateExpiry;
              //appTrace(debug_backtrace(), $user);
              $this->logger->addinfo($user , $e->getMessage());
              if (!$this->saveData($user)) throw new \Exception(get_class($this) ." unable to record data");
      
              //send mail to the user
              $subject = "Thank You For Registering!";
              $message = "Thank you for registering at our site!\n\n";
              $message.= "You can login from this URL:\n";
              $message.= get_current_url()."&action=confirm&token=".$token."\n\n";
              $message.= "The link is going expire automatically after 10 minutes.";
              $fromEmail = 'noreply@'.$_SERVER['SERVER_NAME'];
              sendmail($message, $email, $subject, $fromEmail);
              info("I", "registration confirmation sent");
              /*
               * redirect to home page
               */
              $this->redirect("root", "root");
          } catch (\Exception $e) {
              //appWatch($user, "resetToken()" . $e->getMessage(),get_class($this));
              $this->logger->addError($user , $e->getMessage());
              info("F", "cannot reset token");                //error message
          }
      }
}