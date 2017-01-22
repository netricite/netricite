<?php require_once("netricite/view/vViewInit.php"); ?>   
<h1><?php $this->title = "Le traineau des Gets"; ?>		</h1> 
  <!-- Row section -->
  <article class="row"> 
  	<!-- Nav section (col)-->
    <nav class="col-sm-2" id="myScrollspy">
      <ul class="nav nav-pills nav-stacked" data-spy="affix" data-offset-top="205">    
        <li><a href="#myPage">Acceuil</a></li>
        <li><a href="#services">PRODUITS</a></li>
        <li><a href="#portfolio">TERROIR</a></li>
        <li><a href="#pricing">TARIFS</a></li>
        <li><a href="#contact">CONTACT</a></li>
        <li><a href="#about">ABOUT</a></li>

        <li><a href='index.php?application=shop&class=shop'>Shopping</a></li>

      </ul>
    </nav>
<?php 
use Netricite\Framework as fw;
$cache = new fw\fwCache();
$time=microtime(TRUE);
$cachename="vRoot";
if (!$cache->start($cachename)) {
    ?>

 	<!-- Main section (col)-->
    <section class="col-sm-8">
        <!-- Container (Home Section) -->
        <article id="home" class="container-fluid">
            <header class="panel-heading">
            	<h1 class="text-center">Promotions: Profitez dès maintenant</h1>
            </header>           
          	<h3 class="text-center">Promotions du jour<span class="label label-warning">Nouveau!!!</span></h3>
        		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
    						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
    						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
    						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
    						odio orci rhoncus metus. <a href="#">Read more</a>
    		<h3 class="text-center">Promotions des fêtes de fin d'année<span class="label label-default">Nouvel arrivage!</span></h3>
        		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
    						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
    						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
    						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
    						odio orci rhoncus metus. <a href="#">Read more</a>
    						<div class="panel-body" id="img-content">
		<div class="col-xs-12">
			<div class="row">
				<ul id="push" class="img-profiles img-cf">
				<?php
					echo $this->formgen->imageLink(array("col"=>"1", "file"=>"assiette-huitre.jpg", "legend"=>"Nos assiettes d'huitres", "link"=>"Voir les produits",
					    "index"=>"index.php?application=shop&class=shop#contact"));
					?>
				</ul></div></div></div>
        	<aside class="panel">
        		<h3 class="text-center">Et nous vous proposons comme à l'accoutumée</h3>
        		<p class="w3-large w3-text-grey w3-hide-medium">Excepteur sint occaecat cupidatat non proident, 
        			sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, 
        			sed do eiusmod temporincididunt ut labore et dolore magna aliqua. 
        			Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
        			<a href="#">Read more</a></p>
        <div class="col-xs-12">
			<div class="row">
				<ul id="push" class="img-profiles img-cf">
        			<?php
        			echo $this->formgen->imageLink(array("col"=>"3", "file"=>"saucisson-tranche.jpg", "legend"=>"Charcuterie de Savoie", "link"=>"Voir les produits",
        			    "index"=>"index.php?application=shop&class=shop#services"));
        			echo $this->formgen->imageLink(array("col"=>"3", "file"=>"fromages-vitrine.jpg", "legend"=>"Nos fromages AOP", "link"=>"Voir les produits",
        			    "index"=>"index.php?application=shop&class=shop#portfolio"));
        			echo $this->formgen->imageLink(array("col"=>"3", "file"=>"verre-vin.jpg", "legend"=>"Notre sélection de vins", "link"=>"Voir les produits",
        			    "index"=>"index.php?application=shop&class=shop#pricing"));
					?>
					</ul></div></div></div>
			</aside>        	
            <footer class="panel-footer">
            	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
        						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
        						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
        						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
        						odio orci rhoncus metus.
            <footer class="panel-footer">
        </article>
        
        <!-- Container (services Section) -->
        <article id="services" class="container-fluid">
            <header class="panel-heading">
            	<h1 class="text-center">Une gamme de produits de qualité et de services personnalisés</h1>
            </header>
            	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
        						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
        						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
        						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
        						odio orci rhoncus metus. <a href="#">Read more</a>
        	<aside class="panel">
        		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
        						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
        						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
        						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
        						odio orci rhoncus metus. <a href="#">Read more</a>
        	</aside>
            <footer class="panel-footer">
            	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
        						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
        						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
        						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
        						odio orci rhoncus metus.
            <footer class="panel-footer">
        </article>	<!-- end services section -->
        
        <!-- Container (portfolio Section) -->
        <article id="portfolio" class="container-fluid">
            <header class="panel-heading">
            	<h1 class="text-center">Nos produits du terroir</h1>
            </header>
            	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
        						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
        						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
        						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
        						odio orci rhoncus metus. <a href="#">Read more</a>
        	<div class="panel-body" id="img-content">
        		<div class="col-xs-12">
        			<div class="row">
        				<ul id="push" class="img-profiles img-cf">
        					<?php
        					echo $this->formgen->imageLink(array("col"=>"3", "file"=>"saucisson-tranche.jpg", "legend"=>"Charcuterie de Savoie", "link"=>"Voir les produits",
        					    "index"=>"index.php?application=shop&class=shop#services"));
        					echo $this->formgen->imageLink(array("col"=>"6", "file"=>"verre-vin.jpg", "legend"=>"Notre sélection de vins", "link"=>"Voir les produits",
        					    "index"=>"index.php?application=shop&class=shop#pricing"));
        					echo $this->formgen->imageLink(array("col"=>"3", "file"=>"fromages-vitrine.jpg", "legend"=>"Nos fromages AOP", "link"=>"Voir les produits",
        					    "index"=>"index.php?application=shop&class=shop#portfolio"));
        					echo $this->formgen->imageLink(array("col"=>"6", "file"=>"assiette-huitre.jpg", "legend"=>"Nos assiettes d'huitres", "link"=>"Voir les produits",
        					    "index"=>"index.php?application=shop&class=shop#contact"));
        					?>
        				</ul></div></div></div>
        	<aside class="panel">
        		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
        						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
        						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
        						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
        						odio orci rhoncus metus. <a href="#">Read more</a>
        	</aside>
            <footer class="panel-footer">
            	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
        						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
        						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
        						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
        						odio orci rhoncus metus.
            </footer>
        </article>	<!-- end portfolio section -->
        
        <!-- Container (pricing Section) -->
        <article id="pricing" class="container-fluid">
            <header class="panel-heading">
            	<h1 class="text-center">Nos tarifs</h1>
            </header>
            	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
        						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
        						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
        						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
        						odio orci rhoncus metus. <a href="#">Read more</a>
        	<aside class="panel">
        		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
        						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
        						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
        						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
        						odio orci rhoncus metus. <a href="#">Read more</a>
        	</aside>
            <footer class="panel-footer">
            	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
        						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
        						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
        						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
        						odio orci rhoncus metus.
            </footer>
        </article>	<!-- end pricing section -->
        
        <!-- Container (contact Section) -->
        <article id="contact" class="container-fluid">
            <header class="panel-heading">
            	<h1 class="text-center">Venez nous rejoindre aux Gets</h1>
            </header>
        	<h3 class="text-center">Vu sur notre Facebook</h3>
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#tab0">Audrey</a></li>
              <li><a data-toggle="tab" href="#tab1">Damien</a></li>
              <li><a data-toggle="tab" href="#tab2">La Famille</a></li>
              <li><a data-toggle="tab" href="#tab3">Le Magasin</a></li>
            </ul>
            
            <div class="tab-content">
              <div id="tab0" class="tab-pane fade in active">
                <h2>Audrey, La patronne</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
						odio orci rhoncus metus.</p>
						<div class="item">
                <img  class="img-responsive img-thumbnail" src="public/img/leTraineau/Audrey-Damien-Charlotte.jpg" alt="Vin" style="width:304px;height:228px;">
                <?= $this->formgen->caption("Audrey", "en visite chez l'affineur de fromage"); ?>
              </div>
              </div>
              <div id="tab1" class="tab-pane fade">
                <h2>Damien, le Patron</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
						odio orci rhoncus metus.</p>
						<img  class="img-responsive img-thumbnail" src="public/img/leTraineau/Audrey-Damien-Charlotte.jpg" alt="Vin" style="width:304px;height:228px;">
                <?= $this->formgen->caption("Damien", "en visite chez l'affineur de fromage"); ?>
              </div>
              <div id="tab2" class="tab-pane fade">
                <h2>La Famille</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
						odio orci rhoncus metus.</p>
						<img  class="img-responsive img-thumbnail" src="public/img/leTraineau/letraineau-damien-audrey.jpg" alt="Vin" style="width:304px;height:228px;">
                <?= $this->formgen->caption("Notre famille", "avant l'ouverture du 17 décembre 2016"); ?>
              </div>
              <div id="tab3" class="tab-pane fade">
                <h2>Le Magasin</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
						odio orci rhoncus metus.</p>
						<img  class="img-responsive img-thumbnail" src="public/img/leTraineau/letraineau-damien-audrey.jpg" alt="Vin" style="width:304px;height:228px;" >
                <?= $this->formgen->caption("Le traineau", "avant l'ouverture du 17 décembre 2016"); ?>
              </div>
            </div>        <!-- end tab-content --> 

              <div class="row">
                  <h3 class="text-center">Contact</h3>
                  <p class="text-center"><em>Nous vous adorons!</em></p>
                  <div class="col-md-6">
                      <p><span class="glyphicon glyphicon-map-marker"></span>Les Gets, France - 74260</p>
                      <span class="glyphicons glyphicons-global"></span><a href="http://www.letraineau-lesgets.com/">http://www.letraineau-lesgets.com/</a></p>
                  </div>
                  <div class="col-md-6">
                      <p><span class="glyphicon glyphicon-phone"></span>+0033(6)45861562</p>
                      <p><span class="glyphicon glyphicon-envelope"></span>audrey_guilleron@hotmail.com</p>
                  </div>
              </div>     <!-- end row -->
<?php
$cache->end();
}
$duration = round( microtime( TRUE )-$time, 6 );
//echo "<p>" . $duration . "sec.</p>";
appWatch(array("cached execution(". $cachename .")"=> $duration . " sec"),"", get_class($this));              
              
              echo $this->formgen->formbegin(array("name"=>"formContact"), 
                  array("application"=>"blog","class"=>"comment"), 
                  array("post"=>"", "comment"=>"", "user"=>"", "date_created"=>"", "postid"=>""));
                echo $this->formgen->input(array("type"=>"email", "field"=>"user", "placeholder"=>"votre email", "col"=>"12", "label"=>"email", 
                    "errortext"=>"email address, format: name@example.com",
                  "attr"=>array("required" => "required" )
                    ));
                echo $this->formgen->textarea(array("field"=>"comment", "placeholder"=>"Vos commentaires", "label"=>"commentaire",
                    "attr"=>array("required" => "required")
                ));
                echo $this->formgen->rowend();
                echo $this->formgen->rowbegin();
                echo $this->formgen->divbegin("6");
                echo "Je note le traineau &nbsp;";
                echo '<input type="hidden" class="rating" name="like" id="like" 
                            data-filled="glyphicon glyphicon-heart custom-heart" data-empty="glyphicon glyphicon-heart-empty custom-heart"/>';
                //echo '$(#like).rating();';
                echo $this->formgen->divend();
                //echo $this->formgen->hidden("date_created", "$date");
                echo $this->formgen->hidden("postid", "23");
                echo $this->formgen->hiddenNodata("action", "save");
                
                echo $this->formgen->button(array("field"=>"add","col"=>"6","icon"=>"ok","text"=>"Publier le commentaire"));
                echo $this->formgen->formend();
            ?>  


        	<aside class="panel">
        		<h3 class="text-center">pour nous trouver aux Gets</h3>
        		<p>Rue du centre, en face de la patinoire(place limonaire), au centre du Village des Gets</p>
        		<div id="googleMap"></div>
        
        	</aside>
        </article>	<!-- end contact section -->
        	
        <!-- Container (About Section) -->
        <article id="about" class="container-fluid">
            <header class="panel-heading">
            	<h1 class="text-center">A propos du traineau</h1>
            	
            </header>
            <div class="row">
                <div class="col-sm-8">
                  <h2>L'histoire d'une vie</h2>
                      <h3>Audrey</h3>
                      	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
            						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
            						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
            						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
            						odio orci rhoncus metus. <a href="#">Read more</a></p>
                      <h3>Damien</h3>
                      	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
            						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
            						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
            						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
            						odio orci rhoncus metus. <a href="#">Read more</a></p>
                      <h3>La famille</h3>
                      	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
            						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
            						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
            						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
            						odio orci rhoncus metus. <a href="#">Read more</a></p>
            		  <h3>Le Magasin des Gets</h3>
                      	<p>Suivez nous sur face book <a href="https://www.facebook.com/letraineaulesgets/?fref=ts">Rejoignez nous</a></p>
            		  	<p>ment participatif, grâce au site "Bulb in Town", nous avons lancé notre projet,  
            		  		<a href="https://coupdenvoi.societegenerale.fr/les-projets/le-traineau---produits-regionaux-et-epicerie-fine-2271">Rejoignez nous</a></p>
                  <button class="btn btn-default btn-lg"><a href="#contact">Restons en contact</a></button>        
                </div>
                <div class="col-sm-4">
                  <img class="img-logo-small img-responsive" src="public/img/leTraineau/logo-letraineau.png" alt="Le Traineau">
                </div>
            </div>
        	<aside class="container-fluid bg-grey">
        		<div class="row">
                    <div class="col-sm-4">
                      <img class="img-logo-small img-responsive" src="public/img/leTraineau/logo-letraineau.png" alt="Le Traineau">
                    </div>
                    <div class="col-sm-8">
                      <h2>Nos valeurs</h2>
                      <h3>NOTRE MISSION</h3>
                      <p><strong>Nous croyons que nos clients </strong>lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
        						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
        						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
        						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
        						odio orci rhoncus metus. <a href="#">Read more</a></p>
                      <h3>NOTRE VISION</h3>
                      <p><strong>Notre vision de l'alimentation d'aujourd'hui</strong> lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
        						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
        						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
        						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
        						odio orci rhoncus metus. <a href="#">Read more</a></p>
                    </div>
                  </div>
        	</aside>
           
        </article> 	<!-- end container section -->
        	
        	
        <footer class="panel-footer">
        	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
    						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
    						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
    						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
    						odio orci rhoncus metus.
        </footer>	<!-- end footer -->
    </section>		<!-- end main section -->
    
  </article> <!-- end row -->