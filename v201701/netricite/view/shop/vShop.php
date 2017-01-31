<?php
require ("netricite/view/vViewInit.php");
use Netricite\Framework as fw;
?>
<h1><?php $this->title = "Le traineau des Gets"; ?>		</h1>
<!-- Row section -->
<article class="row">
	<!-- Nav section (col)-->
	<nav class="col-sm-2" id="myScrollspy">
		<ul class="nav nav-pills nav-stacked" data-spy="affix"
			data-offset-top="205">
			<li><a href="index.php?application=root&class=root#myPage">Acceuil</a></li>
			<li><a href="index.php?application=shop&class=shop#top">Haut de page</a></li>
			<li><a href="index.php?application=shop&class=shop#section1">CHARCUTERIE</a></li>
			<li><a href="index.php?application=shop&class=shop#section2">FROMAGES</a></li>
			<li><a href="index.php?application=shop&class=shop#section3">VINS</a></li>
			<li><a href="index.php?application=shop&class=shop#section4">EPICERIE
					FINE</a></li>
			<li><a href="index.php?application=shop&class=shop#section5">RESERVATIONS</a></li>
			<li><a href="index.php?application=shop&class=cart">Mon panier</a></li>
		</ul>
	</nav>

	<!-- Main section (col)-->
<?php
$cache = new fw\fwCache();
$time = microtime(TRUE);
$cachename = "vShop";
$cache->delete($cachename);
if (! $cache->start($cachename)) {
    ?>
    <section class="col-sm-8">

		<!-- Container (Home Section) -->
		<article id="top" class="container-fluid">

			<div id="myCarousel" class="carousel slide" data-ride="carousel">
				<!-- Indicators -->
				<ol class="carousel-indicators">
					<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
					<li data-target="#myCarousel" data-slide-to="1"></li>
					<li data-target="#myCarousel" data-slide-to="2"></li>
					<li data-target="#myCarousel" data-slide-to="3"></li>
				</ol>

				<!-- Wrapper for slides -->
				<div class="carousel-inner" role="listbox">
					<div class="item active">
						<!--  $this->formgen->image(array("file"=>"saucisson-tranche.jpg", "class"=>"img-thumbnail", "boxsize"=>500)); ?> -->
						<img src="public/img/leTraineau/saucisson-tranche.jpg"
							alt="Charcuterie" class="img-thumbnail">
						<div class="stickerNew">Promotion!!!</div>
						<div class="carousel-caption">
							<p>Les meilleurs saucissions de Savoie.</p>
						</div>
					</div>

					<div class="item">
						<img src="public/img/leTraineau/fromages-vitrine.jpg"
							alt="Fromage" class="img-thumbnail">
						<div class="stickerNew">Nouveau !!!</div>
						<div class="carousel-caption">
							<p>FROMAGES: De Savoie et d'ailleurs.</p>
						</div>
					</div>

					<div class="item">
						<img src="public/img/leTraineau/verre-vin.jpg" alt="Vin"
							class="img-thumbnail">
						<div class="carousel-caption">
							<p>Notre sélection de vins</p>

						</div>
					</div>

					<div class="item">
						<img src="public/img/leTraineau/assiette-huitre.jpg" alt="huitres"
							class="img-thumbnail">
						<div class="carousel-caption">

							<p>Des huitres Médaille d'or, Arrivage direct du morbihan
								(Bretagne).</p>
						</div>
					</div>
				</div>

				<!-- Left and right controls -->
				<a class="left carousel-control" href="#myCarousel" role="button"
					data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"
					aria-hidden="true"></span> <span class="sr-only">Previous</span>
				</a> <a class="right carousel-control" href="#myCarousel"
					role="button" data-slide="next"> <span
					class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</article>

		<!-- Container (services Section) -->
		<article id="section1" class="container-fluid">
			<header class="panel-heading">
				<h1 class="text-center">Nos charcuteries de Savoie</h1>
			</header>
           <?php
    echo $this->formgen->rowbegin("12");
    
    $count = count($data);
    $nbColumn = 3;
    for ($i = 0; $i < $count; $i += $nbColumn) {
        for ($col = 0; $col < $nbColumn; $col ++) {
            if ($i + $col < $count) {
                /* load product description in ul */
                $fieldList = array(
                    htmlutf8($data[$i + $col]['unitPrice']) . ".- &euro;",
                    htmlutf8($data[$i + $col]['name']),
                    htmlutf8($data[$i + $col]['description'])
                );
                
                echo $this->formgen->imageCart(array(
                    "col" => "4",
                    "file" => $data[$i + $col]['imgLink'],
                    "id" => $data[$i + $col]['id'],
                    "title" => htmlutf8($data[$i + $col]['shortname']),
                    "legend" => $this->formgen->listUl($fieldList),
                    "sticker" => "Dernier article !!!"
                ));
            } else { // empty row
                echo "&nbsp;";
            }
        } /* end of row */
        echo $this->formgen->rowend();
        echo $this->formgen->rowbegin();
    } /* end of records */
    echo $this->formgen->rowend();
    ?>
        	<aside class="panel">
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
				tristique justo eu sollicitudin pretium. Nam scelerisque arcu at dui
				porttitor, non viverra sapien pretium. Nunc nec dignissim nunc. Sed
				eget est purus. Sed convallis, metus in dictum feugiat, odio orci
				rhoncus metus. <a href="#">Read more</a>
			</aside>
			<footer class="panel-footer">
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
				tristique justo eu sollicitudin pretium. Nam scelerisque arcu at dui
				porttitor, non viverra sapien pretium. Nunc nec dignissim nunc. Sed
				eget est purus. Sed convallis, metus in dictum feugiat, odio orci
				rhoncus metus.
				<footer class="panel-footer">
		
		</article>
		<!-- end services section -->

		<!-- Container (portfolio Section) -->
		<article id="section2" class="container-fluid">
			<header class="panel-heading">
				<h1 class="text-center">Nos fromages des terroirs</h1>
			</header>
        <?php
    echo $this->formgen->rowbegin("12");
    
    $count = count($data);
    $nbColumn = 3;
    for ($i = 0; $i < $count; $i += $nbColumn) {
        for ($col = 0; $col < $nbColumn; $col ++) {
            if ($i + $col < $count) {
                /* load product description in ul */
                $fieldList = array(
                    htmlutf8($data[$i + $col]['unitPrice']) . ".- &euro;",
                    htmlutf8($data[$i + $col]['name']),
                    htmlutf8($data[$i + $col]['description'])
                );
                
                echo $this->formgen->imageCart(array(
                    "col" => "4",
                    "file" => $data[$i + $col]['imgLink'],
                    "id" => $data[$i + $col]['id'],
                    "title" => htmlutf8($data[$i + $col]['shortname']),
                    "legend" => $this->formgen->listUl($fieldList)
                ));
            } else { // empty row
                echo "&nbsp;";
            }
        } /* end of row */
        echo $this->formgen->rowend();
        echo $this->formgen->rowbegin();
    } /* end of records */
    echo $this->formgen->rowend();
    ?>
        	<aside class="panel">
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
				tristique justo eu sollicitudin pretium. Nam scelerisque arcu at dui
				porttitor, non viverra sapien pretium. Nunc nec dignissim nunc. Sed
				eget est purus. Sed convallis, metus in dictum feugiat, odio orci
				rhoncus metus. <a href="#">Read more</a>
			</aside>
			<footer class="panel-footer"> Lorem ipsum dolor sit amet, consectetur
				adipiscing elit. Proin tristique justo eu sollicitudin pretium. Nam
				scelerisque arcu at dui porttitor, non viverra sapien pretium. Nunc
				nec dignissim nunc. Sed eget est purus. Sed convallis, metus in
				dictum feugiat, odio orci rhoncus metus. </footer>
		</article>
		<!-- end portfolio section -->

		<!-- Container (pricing Section) -->
		<article id="section3" class="container-fluid">
			<header class="panel-heading">
				<h1 class="text-center">Nos vins sélectionnés</h1>
			</header>
            	<?php
    echo $this->formgen->rowbegin("12");
    
    $count = count($data);
    $nbColumn = 3;
    for ($i = 0; $i < $count; $i += $nbColumn) {
        
        /* model: echo $this->formgen->imageCart("4","" ,"saucisson.jpg", 1,"Savoie pur porc","19.-- la tonne"); */
        for ($col = 0; $col < $nbColumn; $col ++) {
            if ($i + $col < $count) {
                /* load product description in ul */
                $fieldList = array(
                    htmlutf8($data[$i + $col]['unitPrice']) . ".- &euro;",
                    htmlutf8($data[$i + $col]['name']),
                    htmlutf8($data[$i + $col]['description'])
                );
                
                echo $this->formgen->imageCart(array(
                    "id" => $data[$i + $col]['id'],
                    "col" => "4",
                    "file" => $data[$i + $col]['imgLink'],
                    "title" => htmlutf8($data[$i + $col]['shortname']),
                    "legend" => $this->formgen->listUl($fieldList)
                ));
            } else { // empty row
                echo "&nbsp;";
            }
        } /* end of row */
        echo $this->formgen->rowend();
        echo $this->formgen->rowbegin();
    } /* end of records */
    echo $this->formgen->rowend();
    ?>
        	<aside class="panel">
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
				tristique justo eu sollicitudin pretium. Nam scelerisque arcu at dui
				porttitor, non viverra sapien pretium. Nunc nec dignissim nunc. Sed
				eget est purus. Sed convallis, metus in dictum feugiat, odio orci
				rhoncus metus. <a href="#">Read more</a>
			</aside>
			<footer class="panel-footer"> Lorem ipsum dolor sit amet, consectetur
				adipiscing elit. Proin tristique justo eu sollicitudin pretium. Nam
				scelerisque arcu at dui porttitor, non viverra sapien pretium. Nunc
				nec dignissim nunc. Sed eget est purus. Sed convallis, metus in
				dictum feugiat, odio orci rhoncus metus. </footer>
		</article>
		<!-- end pricing section -->

		<!-- Container (contact Section) -->
		<article id="section4" class="container-fluid">
			<header class="panel-heading">
				<h1 class="text-center">Notre sélection de produits</h1>
			</header>
			<h3 class="text-center">Des produits sélectionnés pour votre plaisir</h3>
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#tab0">Huitres</a></li>
				<li><a data-toggle="tab" href="#tab1">Foie gras</a></li>
				<li><a data-toggle="tab" href="#tab11">Saumon</a></li>
				<li><a data-toggle="tab" href="#tab2">Escargots</a></li>
				<li><a data-toggle="tab" href="#tab3">Vins</a></li>
				<li><a data-toggle="tab" href="#tab4">Spiritueux</a></li>
			</ul>

			<div class="tab-content">
				<div id="tab0" class="tab-pane fade in active">
					<h2>Huitres</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
						odio orci rhoncus metus.</p>

					<div class="thumbnail">
						<img class="img-medium"
							src="public/img/leTraineau/assiette-huitre.jpg" alt="Paris">
						<p>
							<strong>Savoie pur porc</strong>
						</p>
					</div>

				</div>
				<div id="tab1" class="tab-pane fade">
					<h2>Foie gras</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
						odio orci rhoncus metus.</p>
					<div class="thumbnail">
						<img class="img-medium" src="public/img/leTraineau/saumon.jpg"
							alt="Paris">
						<p>
							<strong>Savoie pur porc</strong>
						</p>
					</div>
				</div>
				<div id="tab11" class="tab-pane fade">
					<h2>Saumon</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
						odio orci rhoncus metus.</p>
					<div class="thumbnail">
						<img class="img-medium" src="public/img/leTraineau/saumon.jpg"
							alt="Paris">
						<p>
							<strong>Savoie pur porc</strong>
						</p>
					</div>
				</div>
				<div id="tab2" class="tab-pane fade">
					<h2>Escargots</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
						odio orci rhoncus metus.</p>
					<div class="thumbnail">
						<img class="img-medium" src="public/img/leTraineau/escargot.jpg"
							alt="Paris">
						<p>
							<strong>Savoie pur porc</strong>
						</p>
					</div>
				</div>
				<div id="tab3" class="tab-pane fade">
					<h2>Vins</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
						odio orci rhoncus metus.</p>
					<div class="thumbnail">
						<img class="img-medium" src="public/img/leTraineau/verre-vin.jpg"
							alt="Paris">
						<p>
							<strong>Savoie pur porc</strong>
						</p>
					</div>
				</div>
				<div id="tab4" class="tab-pane fade">
					<h2>Spiritueux</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
						odio orci rhoncus metus.</p>
					<div class="thumbnail">
						<img class="img-medium" src="public/img/leTraineau/verre-vin.jpg"
							alt="Paris">
						<p>
							<strong>Savoie pur porc</strong>
						</p>
					</div>
				</div>
			</div>
			<!-- end tab-content -->

		</article>
		<!-- end contact section -->
        	
<?php
    $cache->end();
}
$duration = round(microtime(TRUE) - $time, 6);
// echo "<p>" . $duration . "sec.</p>";
appWatch(array(
    "cached execution(" . $cachename . ")" => $duration . " sec"
), "", get_class($this));
?>
        <!-- Container (section5 Section) -->
		<article id="section5" class="container-fluid">
			<header class="panel-heading">
				<h1 class="text-center">Réservations</h1>
			</header>
           
            <?php
            /* 3 images per row */
            
            echo $this->formgen->formbegin(array(
                "name" => "formContact",
                "legend" => "Vous pouvez réserver 3 jours à l'avance."
            ), array(
                "application" => "shop",
                "class" => "shop"
            ), array(
                "post" => "",
                "comment" => "",
                "user" => "",
                "date_created" => "",
                "postid" => "",
                "count" => "1",
                "booking" => "",
                "fondue" => "",
                "raclette" => "",
                "huitre" => ""
            ));
            
            echo $this->formgen->imageThumbnail(array(
                "col" => "4",
                "file" => "fondue.jpg",
                "title" => "Fondue(par personne)",
                "legend" => $this->formgen->checkbox("-inline", "fondue", "", array(
                    "fondue" => "Fondue"
                ))
            ));
            echo $this->formgen->imageThumbnail(array(
                "col" => "4",
                "file" => "verre-vin.jpg",
                "title" => "Raclette(par personne)",
                "legend" => $this->formgen->checkbox("-inline", "raclette", "", array(
                    "raclette" => "Raclette"
                ))
            ));
            echo $this->formgen->imageThumbnail(array(
                "col" => "4",
                "file" => "assiette-huitre.jpg",
                "title" => "Huitres(à la douzaine)",
                "legend" => $this->formgen->checkbox("-inline", "huitre", "", array(
                    "huitres" => "Huitres"
                ))
            ));
            
            // echo $this->formgen->imageThumbnail("4", "fondue.jpg", "Fondue(par personne)", $this->formgen->checkbox("-inline","fondue","", array("fondue"=>"Fondue")));
            // echo $this->formgen->imageThumbnail("4", "verre-vin.jpg", "Raclette(par personne)", $this->formgen->checkbox("-inline","raclette","", array("raclette"=>"Raclette")));
            // echo $this->formgen->imageThumbnail("4", "assiette-huitre.jpg", "Huitres(à la douzaine)", $this->formgen->checkbox("-inline","huitre","", array("huitres"=>"Huitres")));
            
            echo $this->formgen->input(array(
                "type" => "email",
                "col" => "12",
                "field" => "user",
                "placeholder" => "votre email",
                "icon" => "envelope",
                "errortext" => "email address, format: name@example.com",
                "tooltip" => "format: name@example.com",
                "attr" => array(
                    "required" => "required"
                )
            ));
            // echo $this->formgen->input("user", "", "Entrez votre email","12","eMail", "" ,array("required" => "required"));
            echo $this->formgen->textarea(array(
                "field" => "comment",
                "placeholder" => "Votre commentaire",
                "label" => "commentaire",
                "tooltip" => "Faîtes nous part de vos besoins!",
                "attr" => array(
                    "required" => "required"
                )
            ));
            // echo $this->formgen->textarea("", "comment", "Votre commentaire","12","commentaire",array("required" => "required"));
            echo $this->formgen->input(array(
                "field" => "count",
                "label" => "nombre de personnes/douzaine d'huitres",
                "errortext" => "saisie invalide",
                "tooltip" => "format: name@example.com"
            ));
            // echo $this->formgen->input("count","", "","","nombre de personnes/douzaine d'huitres");
            
            echo $this->formgen->divbegin("6");
            echo $this->formgen->checkbox("", "booking", "", array(
                "appareil" => "Je réserve aussi un appareil (Fondue/Raclette)"
            ));
            echo $this->formgen->divend();
            
            // echo $this->formgen->hidden("date_created", "$date");
            echo $this->formgen->hidden("postid", "23"); // blog number for "le trianeau"
            echo $this->formgen->hiddenNodata("action", "booking");
            
            echo $this->formgen->buttonSession(array(
                "field" => "add",
                "col" => "12",
                "icon" => "ok",
                "text" => "Réservez maintenant"
            ));
            /*
             * if (!empty($_SESSION['pseudo']) ) {
             * echo $this->formgen->button("add","12","ok","","Réservez maintenant");
             * } else {
             * echo $this->formgen->button("add","12","ban-circle","pull-right", "Réservez maintenant", array("disabled"=>"disabled"));
             * };
             */
            echo "</fieldset>";
            echo $this->formgen->formend();
            ?>
              
        	<aside class="container-fluid bg-grey">
				<p>Préciser le produit et le nombre de parts. nous mettons à votre
					disposition les appareils à fondue et à raclette (1 appareil pour 6
					personnes).</p>
				<p>Note: pour les huitres, indiquez le nombre de douzaine</p>
				<p>Vous recevrez en retour un email de confirmation.</p>

			</aside>
			<footer> </footer>
		</article>
		<!-- end container section -->

		<!-- Container (Section6) -->
		<article id="section6" class="container-fluid"></article>
		<!-- end container section -->

		<footer class="panel-footer"> Lorem ipsum dolor sit amet, consectetur
			adipiscing elit. Proin tristique justo eu sollicitudin pretium. Nam
			scelerisque arcu at dui porttitor, non viverra sapien pretium. Nunc
			nec dignissim nunc. Sed eget est purus. Sed convallis, metus in
			dictum feugiat, odio orci rhoncus metus. </footer>
		<!-- end footer -->
	</section>
	<!-- end main section -->
</article>
<!-- end row -->
</section>




