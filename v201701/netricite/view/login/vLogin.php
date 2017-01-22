<?php require_once("netricite/view/vViewInit.php"); ?>   
<?php $this->title = "My Blog - Login" ?>  

    <h1 id="login">Bienvenue ! </h1>   
    
     <div class="row">
  		<div class="col-sm-4">
  		<!-- GOOGLE SIGN BUTTON -->
	<!-- <button  id="authorize-button" onclick="handleAuthClick()"><img class="responsive img-social" src="public/img/signin_button.png" alt="google signin"  /></button> -->
	<!-- AUTOLOGIN if user is already login with GOOGLE, else the user pushes the button and the user have to enter his password -->
			<div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>
			<div id="gstatus">Vous pouvez vous connecter sur Google+</div>
  		</div>
  		
  		<div class="col-sm-4">
  		    <!--
              Below we include the Login Button social plugin. This button uses
              the JavaScript SDK to present a graphical Login button that triggers
              the FB.login() function when clicked.
            -->
	

        	<fb:login-button scope="public_profile,email" onlogin="checkLoginState();" data-auto-logout-link="true" data-scope="public_profile, email">
        	</fb:login-button>
        	<div id="fbstatus">Vous pouvez vous connecter sur Facebook</div>
  		</div>
  		
	</div>

    <?php   
    
    /* FORM : NEW TODO TASK */
    echo $this->formgen->formbegin(array("name"=>"formTest","col"=>"12"), 
	    array("application"=>"login","class"=>"login"), 
        array("pseudo"=>"", "pwd"=>""));
	echo "<fieldset>";
	echo "<legend>Veuillez vous connecter</legend>";
	
	echo $this->formgen->input(array("field"=>"pseudo", "placeholder"=>"votre email", "icon"=>"user", "col"=>"6","errortext"=>"pseudo minimum 5 characters",
	    "attr"=>array("required" => "required", "autofocus" => "autofocus" )
	));
	echo $this->formgen->input(array("type"=>"password", "field"=>"pwd", "placeholder"=>"votre mot de passe", "icon"=>"lock", "col"=>"6",
	    "errortext"=>"password 6 to 20 characters, at least one numeric digit, one uppercase, one lowercase letter",
	    "attr"=>array("required" => "required", "autofocus" => "autofocus" )
	));
	
	echo $this->formgen->hiddenNodata("action", "login");
	
	echo $this->formgen->button(array("field"=>"reset","col"=>"5","icon"=>"refresh","text"=>"reset password", "value"=>"reset", 
	    "tooltip"=>"pseudo obligatoire, un email vous sera envoyé"));
	echo $this->formgen->button(array("field"=>"save","col"=>"1","icon"=>"log-in","text"=>"login", "value"=>"save"));

	echo "<fieldset>";
	echo $this->formgen->formend();
	echo $this->formgen->rowbegin();
	echo '<div class="form-group">';
	
	echo '<p ><a href="index.php?application=login&class=registration">Pas encore de compte? Rejoignez-nous</a></p>';
	echo $this->formgen->divend();
	echo $this->formgen->rowend();
    
	
	?> 
	
	
	
	
	

     
     
     
     


