<?php require("netricite/view/vViewInit.php"); 
use Netricite\Framework as fw;
?>   	
<h1><?php $this->title = "Mon compte"; ?>		</h1> 
  <!-- Row section -->
  <article class="row">
  	<!-- Nav section (col)-->
    <nav class="col-sm-2" id="myScrollspy">
      <ul class="nav nav-pills nav-stacked" data-spy="affix" data-offset-top="205">    
        <li><a href="index.php?application=root&class=root#myPage">Acceuil</a></li>
        <li><a href="index.php?application=shop&class=account#section1">Mes coordonnées</a></li>
        <li><a href="index.php?application=shop&class=account#section2">Mes adresses de livraison</a></li>
        <li><a href="index.php?application=shop&class=account#section3">Mes moyens de paiements</a></li>
        <li><a href="index.php?application=shop&class=account#section4">Mes commandes</a></li>
      </ul>
    </nav>
 
 	<!-- Main section (col)-->

    <section class="col-sm-8">
        <!-- Container (section1 Section) -->
        <article id="section1" class="container-fluid">
            <header class="panel-heading">
            	<h1 class="text-center">Mes coordonnées</h1>
            </header>
           <?php 
            require $GLOBALS['application.root.path'] .  "view/login/vRegistration.php";
            //require "netricite/login/vRegistration.php";
            ?>
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
        
        <!-- Container (section2 Section) -->
        <article id="section2" class="container-fluid">
            <header class="panel-heading">
            	<h1 class="text-center">Mes adresses de livraison</h1>
            </header>
        <?php 
        echo $this->formgen->rowbegin("12");
        
        echo $this->formgen->rowend();
        ?>
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
        
        <!-- Container (section3 Section) -->
        <article id="section3" class="container-fluid">
            <header class="panel-heading">
            	<h1 class="text-center">Mes moyens de paiement</h1>
            </header>
            	<?php 
        echo $this->formgen->rowbegin("12");
        
        echo $this->formgen->rowend();
        ?>
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
        
        <!-- Container (section4 Section) -->
        <article id="section4" class="container-fluid">
            
        	 <header class="panel-heading">
            	<h1 class="text-center">Mes commandes</h1>
            </header>

			
              
        	<aside class="container-fluid bg-grey">
        		<p>Vous pouvez visualiser toutes vos commandes et obtenir une facture pour chaque commandes.</p>
            	
        	</aside>
                <p><a class="pull-right" href='index.php?application=shop&class=order' target='_blank' class='pull-left'>Visualiser vos commandes</a></p>
                
		</article>	<!-- end section4 -->
        	
        
    </section>		<!-- end main section -->
  </article> <!-- end row -->
</section>



