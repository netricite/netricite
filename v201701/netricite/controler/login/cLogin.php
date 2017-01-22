<?php
namespace  Netricite\controler\login;

use Netricite\Framework as fw;
use Netricite\Model\Login as login;

/**
 * controler of the LOGIN view
 *
 * @author jp
 * @version 2016-14
 *
 */
 class cLogin extends fw\fwControlerSession{
	
    /**
     * constructor
     */
    public function __construct(){		
        appTrace(debug_backtrace());
        $this->model = new login\mUser();
    }
    
    /**
     * manage login command
     * @throws fw\fwException
     */
    public function login(){
		appTrace(debug_backtrace());
		unset($_POST['action']);
		if (!isset($_POST['data']['pseudo'])) throw new \Exception(get_class($this) . "Invalid pseudo");
		if (!empty($this->getRecord($_POST['data']['pseudo'], "pseudo"))) {
		    if (isset($_POST['reset']))  {	        
		        $this->sendConfirm($this->record);
		    } else {
		        unset($_POST['save']);
		        if (isset($_POST['data']['pwd']  )) {
		            trace(debug_backtrace());
		            $login = $_POST['data']['pseudo'];
		            $pwd = $_POST['data']['pwd'];
		            //get the user
		            $user = $this->model->login($login, $pwd);
		            appWatch($user, "cLogin.login(record)",get_class($this));
		            if (!empty($user)) {
		                //set url
		                $_SESSION["userid"]=$user[0]['id'];
		                $_SESSION["pseudo"]=$user[0]['pseudo'];
		                /*
		                 * save next action to execute
		                 */
		                $nextClass=$_SESSION["nextClass"];
		                $nextApplication=$_SESSION["nextApplication"];
		        
		                appWatch(array("cLogin.login(nextApplication)"=>$nextApplication,
		                    "cLogin.login(nextClass)"=>$nextClass), "login.save(next)",get_class($this));
		                /*
		                 * redirect to action requested by the user before login
		                 */
		                $this->redirect($nextApplication, $nextClass);
		            } else $this->generateView(array('pseudo' => $_POST['data']['pseudo'],
		                'errorMessage' => 'invalid login information'), "index");
		        } else $this->generateView(array('pseudo' => $_POST['data']['pseudo'],
		            'errorMessage' => 'login error'), "missing data");
		    }
		    
		} else $this->generateView(array('errorMessage' => 'login invalide'), "index");
		info("w", "login invalide");  //error message
    }
    
    /**
     * manage logout action
     */
    public function logout(){
		appTrace(debug_backtrace());								
        $this->request->getSession()->destroy();
		//redirect to home page
        $this->home();
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
     * manage resetPassword
     *
     * @param array $user
     * @throws \Exception
     */
    public function sendConfirm($user){
        try {
            appTrace(debug_backtrace(), $user);
            unset($_POST['reset']);
            if (empty($user)) throw new \Exception(get_class($this) . " unable to reset password" );
            
            //save user data
            $id=$user['id'];
            $email=$user['email'];
            
            //update user data
            $user=array();                            //reset record
            $user['id']=$id;                          //for update
            $user['status']=0;                        //status inactive
            $token=generateToken($email,128);
            $user['token']=$token;                    //new token
            $tokenPwd=generateToken($email,8);
            $user['pwd']=$tokenPwd;                   //new password
            $dateExpiry = date('Y-m-d H:i:s',strtotime("+10 minutes"));
            $user['tokenexpiry']=$dateExpiry;
            appTrace(debug_backtrace(), $user);
            if (!$this->saveData($user)) throw new \Exception(get_class($this) ." unable to record data");
    
            //send mail to the user
            $subject = "Password reset";
            $message = "Your password has been reset\n\n";
            $message.= "You can login with the following password \n";
            $message.= $tokenPwd."\n\n";
            $message.= "Please click on this URL:\n";
            $message.= get_page_url()."&action=confirm&token=".$token."\n\n";
            $message.= "The link is going expire automatically after 10 minutes.";
            $fromEmail = 'noreply@'.$_SERVER['SERVER_NAME'];
            sendmail($message, $email, $subject, $fromEmail);
            info("I", "reset confirmation sent");
            /*
             * redirect to home page
             */
            $this->redirect("root", "root");
        } catch (\Exception $e) {
            appWatch($user, "sendConfirm()" . $e->getMessage(),get_class($this));
            info("F", "cannot reset password");                //error message
        }
    }
    
    /**
     * manage confirm action
     *
     */
    public function confirm(){
        try {
            appTrace(debug_backtrace(), $this->request->parameters);
            if (empty($this->request->parameters)) throw new \Exception(get_class($this) . " invalid callback confirm" );
            $conditions="token='" .$this->request->getParameter('token'). "' AND tokenExpiry > NOW()";
            if (empty($this->get(array("conditions"=>$conditions)))) throw new \Exception(get_class($this) ." unable to get valid token");
            $this->setActive($this->record[0]);
            /*
             * redirect to home page
             */
            $this->redirect("root", "root");
        } catch (\Exception $e) {
            appWatch($this->request->parameters, "confirm(url.paramaters)" . $e->getMessage(),get_class($this));
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
          appTrace(debug_backtrace(), $record);
          if (empty($record)) throw new \Exception(get_class($this) . " unable to change status" );
          $id=$record['id'];
          $email=$record['email'];
          $record=array();                                           //reset record
          $record['id']=$id;                                         //current id
          $record['status']=1;                                       //status active
          $record['date_created']=date('Y-m-d H:i:s');               //today
          $record['tokenexpiry']=$record['date_created'];            //cannot execute twice
          $record['token']=null;                                     //empty
          if (!$this->saveData($record)) throw new \Exception(get_class($this) ." unable to record data");
    
          //send confirmation mail to the user
          $subject = "Password reset!";
          $message = "Your password has been reset\n\n";
          $message.= "Please change your password during next login \n";
          $fromEmail = 'noreply@'.$_SERVER['SERVER_NAME'];
          sendmail($message,$email, $subject, $fromEmail);
          info("I", "password reset done");
    
        } catch (\Exception $e) {
            appWatch($this->record, "setActive()" . $e->getMessage(),get_class($this));
            info("F", "cannot activate user");                //error message
        }
    }
}