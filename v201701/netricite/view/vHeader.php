<header class="jumbotron text-center">
	<a href="index.php?application=root&class=root"><img class="img-logo-small" src="public/img/leTraineau/logo-letraineau.png" alt="Le Traineau"></a>
  
    		<!-- <h1 id="titreBlog">  <?= $this->title ?> </h1>-->
			
			 <?php require("netricite/view/vNav.php"); ?> 
			 
	<div class="pull-right">
	
    	<div id="returnCode">
        	<?php if (isset($errorMessage)): ?>
    			<?= $errorMessage ?>
    		<?php endif; ?>
    		<?php if (isset($_SESSION['info']) && $_SESSION['info']!=""){  				           
              	    echo $_SESSION['info'] ;
              	}  ?>
        </div>
        <div id="info"></div>
        
        
	</div>
</Header>


      