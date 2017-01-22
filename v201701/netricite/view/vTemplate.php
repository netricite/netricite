<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">

    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="Le traineau website">
	<meta name="keywords" content="HTML,CSS,XML,JavaScript">
	<meta name="author" content="JP Guilleron">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:url"           content="http://local.netricite.com/netricite/v2016-14/index.php" />
	<meta property="og:type"          content="website" />
	<meta property="og:title"         content="Le Traineau - LES GETS" />
	<meta property="og:description"   content="Epicerie fine" />
	<meta property="og:image"         content="http://local.netricite.com/netricite/v2016-14/public/img/leTraineau/logo-leTraineau.png" />

    <meta name="google-signin-client_id" content="530780569881-5ndq0508il1k82qjpp4ttvo9uaqmak4i.apps.googleusercontent.com">
    <base href="<?= "/" . $GLOBALS["web.base"] ?>">
    
    <!-- BOOTSTRAP Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    
    <!-- New Font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
	
	<!-- Application specific -->
    <link href="public/css/style.css?d=<?php echo date('dm'); ?>" rel="stylesheet" />
    <link href="public/css/test.css?d=<?php echo date('dm'); ?>" rel="stylesheet" />
  
    <!-- Application tab title -->
    <title>
    <?= $this->title . " (" . $GLOBALS["application.version"] . ")" ;?></title>
    <link rel="shortcut icon" type="image/x-icon" href="public/img/leTraineau/savoie.svg" />
    
     <!-- BEGIN GOOGLE Pre-requisites -->
  	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  	<script src="https://apis.google.com/js/platform.js" async defer></script>
  	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- END Pre-requisites -->
    </head>

  	<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
  	<div id="fb-root"></div>

<script>
//This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response) {
  console.log('statusChangeCallback');
  console.log(response);
  // The response object is returned with a status field that lets the
  // app know the current login status of the person.
  // Full docs on the response object can be found in the documentation
  // for FB.getLoginStatus().
  if (response.status === 'connected') {
    // Logged into your app and Facebook.
    //FBlogin();
    FBloginAPI();
  } else if (response.status === 'not_authorized') {
    // The person is logged into Facebook, but not your app.
    document.getElementById('fbstatus').innerHTML = 'Veuillez vous logger ' +
      'sur votre application';
  } else {
    // The person is not logged into Facebook, so we're not sure if
    // they are logged into this app or not.
    document.getElementById('fbstatus').innerHTML = 'Veuillez vous logger ' +
      'sur Facebook.';
  }
}

// This function is called when someone finishes with the Login
// Button.  See the onlogin handler attached to it in the sample
// code below.
function checkLoginState() {
	console.log('checkLoginState');
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}

window.fbAsyncInit = function() {
	  FB.init({
	    appId      : '{1244529312252216}',
	    cookie     : true,  // enable cookies to allow the server to access 
	                        // the session
	    xfbml      : true,  // parse social plugins on this page
	    version    : 'v2.8' // use graph api version 2.8
	  });

	  // Now that we've initialized the JavaScript SDK, we call 
	  // FB.getLoginStatus().  This function gets the state of the
	  // person visiting this page and can return one of three states to
	  // the callback you provide.  They can be:
	  //
	  // 1. Logged into your app ('connected')
	  // 2. Logged into Facebook, but not your app ('not_authorized')
	  // 3. Not logged into Facebook and can't tell if they are logged into
	  //    your app or not.
	  //
	  // These three cases are handled in the callback function.
		console.log('fbAsyncInit');
	  FB.getLoginStatus(function(response) {
	    statusChangeCallback(response);
	  });

	  };

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.8&appId=1244529312252216";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


function FBlogin() {
	  FB.login(function (response) {
		console.log(JSON.stringify(response));   
		if (response.authResponse){
			console.log('User logged.')
			FBloginAPI();
          } else {
            console.log('Auth cancelled.')
          }
	  }, { scope: 'public_profile, email' });

	}

//Here we run a very simple test of the Graph API after login is
// successful.  See statusChangeCallback() for when this call is made.
function FBloginAPI() {
  console.log('Welcome!  Fetching your information.... ');
  FB.api('/me?fields=name, first_name, email, picture', function(profile) {
	console.log(JSON.stringify(profile));   
	console.log('Successful login for: ' + profile.id);
    console.log('Successful login for: ' + profile.name);
    document.getElementById('fbstatus').innerHTML =
      'Merci de vous logger, ' + profile.first_name + '!';
    
    var info = {'fullname' : profile.name, 'familyname' : profile.last_name, 'givenname' : profile.first_name,
			  'img' : profile.picture.data.url, 'email' : profile.email};   
	
    console.log(JSON.stringify(info));   
    //load session info 
    $.ajax({
		url: 'netricite/async/asyncSocialLogin.php',
		type: 'POST',
		data: {profile:info},
		success: function(data) {		
			console.log( "FBloginAPI completed" );
		}});
  });
}

</script>

	
        <!-- Site Header -->
        <?php
        require("netricite/view/vHeader.php"); 
		?>   	

		<!-- application section -->
		<section class="container">
			<?= $content?>
		</section>
		    
		<aside>
			
		</aside>
    			
    			
        <!-- Site footer -->
		<?php 
		/*
		use Netricite\Framework as fw;
		$cache = new fw\fwCache();
		$time=microtime(TRUE);
		$form="netricite/view/vfooter.php";
		$cache->requireFile($form);
		$duration = round( microtime( TRUE )-$time, 6 );
		//echo "<p>" . $duration . "sec.</p>";
		fwWatch("cached execution(". $form .")". $duration . " sec","","vTemplate");
		*/
		
		require("netricite/view/vfooter.php");
		
		//reset 'info' for the next page
		$_SESSION["info"] = "";
		?>
    
    	<!-- Modal windows (fade)-->
    	<?php require("netricite/view/vModal.php"); ?>
    	
	<!-- Javascript - General-->
	<!-- 
	Les scripts javascript doivent �tre plac�s dans un fichier externe � la page HTML. 
	Habituellement on place la balise d'insertion des fichiers dans le <head> . 
	Pour une question de performances on préfèrera la placer à la fin de la page, juste avant </body> 
	à noter que les deux méthodes sont valides du point de vue de la spécification HTML et XHTML.
	Le traitement d'une page web par un navigateur est s�quentiel, de haut en bas. 
	Placer les scripts au plus bas permet de charger les éléments importants de la page web 
	(le contenu et la pr�sentation) avant de s'occuper des paillettes que représente le script javascript. 
	De plus en pla�ant le javascript tout en bas, il est possible d'utiliser le DOM directement 
	et avant l'habituel évènement onload de la page HTML.
	 -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	
	<!-- Google client API -->
	<!--
 	<script async defer src="https://apis.google.com/js/api.js"
      onload="this.onload=function(){};handleClientLoad()"
      onreadystatechange="if (this.readyState === 'complete') this.onload()">
    </script>
	-->
	
    <!-- BOOTSTRAP Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	
 	<!-- Application helper JavaScript -->
 	<script type="text/javascript" src="public/js/helper.js?d=<?php echo date('dm'); ?>"></script>

 	<!-- Javascript - LOGIN/registration application level-->
 	<script type="text/javascript" src="public/js/fnformValidator.js?d=<?php echo date('dm'); ?>"></script>
 	<script type="text/javascript" src="public/js/GoogleAuth.js?d=<?php echo date('dm'); ?>"></script>
 	 	
 	<!-- Javascript - embeded applications -->
 	<script type="text/javascript" src="public/js/bootstrap-rating.min.js?d=<?php echo date('dm'); ?>"></script>
 	<script src="public/js/prefixfree.min.js"></script>

    <script>
    //GOOGLE SCRIPT
    function signOut() {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
          	console.log('vTemplate.signOut() - User signed out.');
          	//click signoff button to complete application signoff
        	//$( "#signoff" ).click();
        });
      }
    function onSignIn(googleUser) {
      var profile = googleUser.getBasicProfile();
      console.log("ID: " + profile.getId()); // Don't send this directly to your server!
      console.log('Full Name: ' + profile.getName());
      console.log('Given Name: ' + profile.getGivenName());
      console.log('Family Name: ' + profile.getFamilyName());
      console.log("Image URL: " + profile.getImageUrl());
      console.log("Email: " + profile.getEmail());

      document.getElementById('fbstatus').innerHTML =
          'Merci de vous logger, ' + profile.getGivenName + '!';
      
	  var info = {'fullname' : profile.getName(), 'familyname' : profile.getFamilyName(), 'givenname' : profile.getGivenName(),
			  'img' : profile.getImageUrl(), 'email' : profile.getEmail()};      
      //load session info 
      $.ajax({
  		url: 'netricite/async/asyncSocialLogin.php',
  		type: 'POST',
  		data: {profile:info},
  		success: function(data) {		
  			console.log( "onSignIn completed" );
  		}});
    }
	var map;
	function initMap() {
  	map = new google.maps.Map(document.getElementById('googleMap'), {
    	center: {lat: 46.158622, lng: 6.669988},
    	zoom: 18
  		});
	}
    </script>
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4NUPNass2MBO8i2OqtcoiXVOP1ggWLH8&callback=initMap">
    </script>
    
    </body>

</html>