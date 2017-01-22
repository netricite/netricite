<div class="l-page__site--aside ">
<nav>
      <ul>
        <li id="login">
          <a id="login-trigger" >
            Log in <span id="login-icone">&#x25BC;</span>
          </a>
       
          <div id="login-content">
            <form action="login/login/login" method="post" >
              <fieldset id="inputs">
                <input id="username" type="text" name="pseudo" placeholder="Your email address" required>   
                <input id="password" type="password" name="pwd" placeholder="Password" required>
              </fieldset>
              <fieldset id="actions">
                <input  type="submit" id="submit" value="Log in">
                <label><input type="checkbox" checked="checked"> Keep me signed in</label>
              </fieldset>
            </form>
          </div>                     
        </li>
        <li id="signup">
          <a href="#">Sign up FREE</a>
        </li>
      </ul>
    </nav>
    
    <aside class="l-page__site--popup">
	  <div id="returnCode">
    	<?php if (isset($errorMessage)): ?>
			<?= $errorMessage ?>
		<?php endif; ?>
		<?php if (isset($_SESSION['info']) && $_SESSION['info']!=""){  				           
          	    echo $_SESSION['info'] ;
          	}  ?>
      </div>
    </aside>  
   
    
    <?php if (isset($_SESSION['pseudo']) && $_SESSION['pseudo']!=""): ?>
    	<p> bonjour <?= $_SESSION['pseudo'] ?>  
    <?php endif; ?>
    	
    </br></br>
		
    <ul>
        <li><a  href="<?= "index.php?application=shop&class=cart" ?>"><img src="public/img/cart.png" alt="Mon panier" height="20" />Mon panier</a>
 						<span id="count">
						
						<?php 
						//var_dump($_SESSION['cart']);
						if(isset($_SESSION['cartCount'])){
						    echo $_SESSION['cartCount'];
						} else {
						    echo 0;
						}
						?></span>
					Articles
					
			</li>
		
		<li><a href='index.php?application=shop&class=cart&action=reset'>Reset panier</br></a></li>
		</ul>
		</br></br>
		
	<ul >
		<li><a href='index.php?application=shop&class=shop'>Shopping</a></li>
        <li><a href='index.php?application=blog&class=blog'>Blog</a></li>
        <li><a href='index.php?application=chat&class=chat' id="chatNewMessage">Chat</a></li>    
        <li><a href='index.php?application=slider&class=slider'>Slider</a></li>
        <li><a href='index.php?application=carousel&class=carousel'>Carousel</a></li>  
    </ul>
    
    </br></br>
    <hr>
    
    
    
    <div >
        <ul >
        <li >your ads here</li>
    </ul>

    <div data-icon="s"></div>
				<div>
					<h4>Cloud</h4>
					<div>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
						tristique justo eu sollicitudin pretium. Nam scelerisque arcu at
						dui porttitor, non viverra sapien pretium. Nunc nec dignissim
						nunc. Sed eget est purus. Sed convallis, metus in dictum feugiat,
						odio orci rhoncus metus. <a href="#">Read more</a>
					</div>
				</div>
				
				</br></br>
<p>Quod si rectum statuerimus vel concedere amicis, quidquid velint, vel impetrare ab iis, quidquid velimus, perfecta quidem sapientia si simus, nihil habeat res vitii; sed loquimur de iis amicis qui ante oculos sunt, quos vidimus aut de quibus memoriam accepimus, quos novit vita communis. Ex hoc numero nobis exempla sumenda sunt, et eorum quidem maxime qui ad sapientiam proxime accedunt.</p>

<p>Victus universis caro ferina est lactisque abundans copia qua sustentantur, et herbae multiplices et siquae alites capi per aucupium possint, et plerosque mos vidimus frumenti usum et vini penitus ignorantes.</p>

<p>Alii summum decus in carruchis solito altioribus et ambitioso vestium cultu ponentes sudant sub ponderibus lacernarum, quas in collis insertas cingulis ipsis adnectunt nimia subtegminum tenuitate perflabiles, expandentes eas crebris agitationibus maximeque sinistra, ut longiores fimbriae tunicaeque perspicue luceant varietate liciorum effigiatae in species animalium multiformes.</p>
    