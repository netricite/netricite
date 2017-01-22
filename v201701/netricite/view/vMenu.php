<div id='cssmenu'>
    <ul>
       <li class='menuactive'><a href='#'>Home</a></li>
       <li class='has-sub'><a href='#'>Shopping</a>
       		<ul>
               <li><a href='index.php?application=shop&class=shop'>Le Magasin</a></li>
			   <li><a class="cart" href="<?= "index.php?application=shop&class=cart" ?>"><img src="public/img/cart.png" alt="Mon panier" height="20" />Mon panier</a>
       		</ul>
       </li>
       <li><a href='index.php?application=blog&class=blog'>Blog</a></li>
       <li><a href='index.php?application=chat&class=chat'>Chat</a></li>
       <li><a href='index.php?application=todo&class=todo'>To do</a></li>
       
       <li class='has-sub'><a href='#'>Utilities</a>
          <ul>
             <li class='has-sub'><a href='#'>tools</a>
                <ul>                 
                   <li><a href='index.php?application=test&class=test'>Test</a></li>
    			   <li><a href='index.php?application=message&class=email'>Email</a></li>
    			   
                </ul>
             </li>
             <li class='has-sub'><a href='#'>Applications</a>
                <ul>
                   <li><a href='index.php?application=admin&class=profile'>Profile</a></li>
    			   <li><a href='index.php?application=carousel&class=carousel'>Carousel</a></li>
    			   <li><a href='index.php?application=admin&class=uploadimg'>Image upload</a></li>
                </ul>
             </li>
          </ul>
       </li>
       
       <li class='has-sub'><a href='#'>About</a>     
            <ul>
               	<li><a href='index.php?application=about&class=contact'>Contact</a></li>
			   	<li><a href='index.php?application=about&class=about'>Preference</a></li>
				<li><a href='index.php?application=about&class=about'>About</a></li>
            </ul>
       </li>
       <li class='has-sub'><a href='#'>Login</a>     
       		<ul>
       		    <li><a href='index.php?application=login&class=login&action=logout'>Logout</a></li>
       			<li><a href='index.php?application=login&class=login&action=login'>Login</a></li>
       		</ul>
       </li>

       <li><a class="cart" href="<?= "index.php?application=shop&class=cart" ?>"><img src="public/img/cart.png" alt="Mon panier" height="20" />Mon panier</a>
        
    </ul>


</div>

