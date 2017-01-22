<?php require("netricite/view/vViewInit.php"); ?> 

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>  
        <span class="icon-bar"></span>      
        <span class="icon-bar"></span>  
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                             
      </button>
      <a class="navbar-brand" href="index.php?application=root&class=root"><img class="img-logo-small img-responsive" src="public/img/leTraineau/savoie.svg" alt="Le Traineau"></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li class="active"><a href="index.php?application=root&class=root">Acceuil</a></li> 
        <li><a href="index.php?application=about&class=contact">CONTACT</a></li>         
        <li class="dropdown">
    		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Applications
    		<span class="caret"></span></a>
           	<ul class="dropdown-menu">
          		<li><a href="index.php?application=todo&class=todo">TODO</a></li>
            	<li><a href="index.php?application=blog&class=blog">BLOG</a></li>
            	<li><a href="index.php?application=chat&class=chat">CHAT</a></li>
            	<li><a href="index.php?application=test&class=test">TEST</a></li>
        	</ul>
        </li>	
        <li><a href="index.php?application=shop&class=shop">SHOPPING</a></li> 
   		<li><?php echo $this->formgen->iconHref('index.php?application=shop&class=cart', "shopping-cart", "Ajouter au panier", array_sum($_SESSION['cart']) );?></li>
   		<li><a href="index.php?application=shop&class=account">Mon compte</a></li> 
        <li><a href="index.php?application=about&class=about">A propos</a></li>
		<?php
		$action="";
		$onclick="";
		$login= empty($_SESSION['pseudo']) ? "Login" : $_SESSION['pseudo'];
		fwTrace(debug_backtrace(), $_SESSION, "vNav.php");
		if (!empty($_SESSION['pseudo'])) {
		    $img='';
	        if(!empty($_SESSION["img"])) {
	            $img='<img class="img-user" src=' . $_SESSION["img"]. ' alt=""  />';
	        }
	    	$login=$_SESSION['pseudo']   . $img;
	    	$action="&action=logout ";
	    	$onclick=" onclick='signOut();'";
	    }
		//watch("vNav.php(pseudo)" . $login);
		?>
        <li><a id="signoff" href="index.php?application=login&class=login<?=$action?> " <?=$onclick?> ><span class="glyphicon glyphicon-user"><?=$login?></span></a></li>
        
		<!-- <li><a href='index.php?application=login&class=login&action=logout'><span class="glyphicon glyphicon-off">Logout</span></a></li> -->  
      </ul>    
    </div>
  </div>
</nav>
<?php
		//var_dump($login);
		//var_dump($_SESSION);
		?>
<!--         <li><a data-toggle="modal" data-target="#myModal-login"><span class="glyphicon glyphicon-user">Login</span></a></li> -->  