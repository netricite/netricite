<?php $this->title = "Le traineau - Epicerie fine - les Gets" ?>
 
<div class="slider__frame">
    <div id="slider">
        <div class="slide" id="slide1">
        <div><img class="slide__img" src="public/img/slider/s1.jpg" alt="slide" /></div>
        <div class="slide__text">
            <h1>Le traineau</h1>
                <ul >
                    <li style="color: blue;"><img class="slide__icon" src="public/img/slider/s1.jpg" alt="HTML structure" /> <a href="index.php">Voyage au Canada</a></li>
                    <li style="color: red;"><img class="slide__icon" src="public/img/slider/s1.jpg" alt="HTML structure" /> <a href="index.php">Une jolie montre</a></li>
                    <li style="color: green;"><img class="slide__icon" src="public/img/slider/s2.jpg" alt="HTML structure" /> <a href="index.php">Voyage aux USA</a></li>
                </ul>
                
            <form  method="post" action="commande.php">
            <input class="slide__button" type="submit" value="j'en profite" /></form>
        </div>
        <div><img class="slide__img" src="public/img/slider/s2.jpg" alt="slide" /></div>
        </div>
        
        <div class="slide" id="slide2">
        <div><img class="slide__img" src="public/img/slider/disney1.jpg" alt="slide" /></div>
        <div class="slide__text">
        <h1>Le traineau</h1>
        <ul >
        <li style="color: blue;"><img class="slide__icon" src="public/img/slider/disney1.jpg" alt="HTML structure" /> <a href="index.php">Voyage au Canada</a></li>
        <li style="color: red;"><img class="slide__icon" src="public/img/slider/disney1.jpg" alt="HTML structure" /> <a href="index.php">Une jolie montre</a></li>
        <li style="color: green;"><img class="slide__icon" src="public/img/slider/disney2.jpg" alt="HTML structure" /> <a href="index.php">Voyage aux USA</a></li>
        </ul>
        <form  method="post" action="commande.php">
        <input class="slide__button" type="submit" value="j'en profite" /></form>
        </div>
        <div><img class="slide__img" src="public/img/slider/disney2.jpg" alt="slide" /></div>
        </div>
        
        <div class="slide" id="slide3">
        <div><img class="slide__img" src="public/img/slider/slide1.jpg" alt="slide" /></div>
        <div class="slide__text">
        <h1>Le traineau</h1>
        <ul >
        <li style="color: blue;"><img class="slide__icon" src="public/img/slider/slide1.jpg" alt="HTML structure" /> <a href="index.php">Voyage au Canada</a></li>
        <li style="color: red;"><img class="slide__icon" src="public/img/slider/slide1.jpg" alt="HTML structure" /> <a href="index.php">Une jolie montre</a></li>
        <li style="color: green;"><img class="slide__icon" src="public/img/slider/slide2.jpg" alt="HTML structure" /> <a href="index.php">Voyage aux USA</a></li>
        </ul>
        <form  method="post" action="commande.php">
        <input class="slide__button" type="submit" value="j'en profite" /></form>
        </div>
        <div><img class="slide__img" src="public/img/slider/slide2.jpg" alt="slide" /></div>
        </div>
        
        <div class="slide" id="slide4">
        <div><img class="slide__img" src="public/img/slider/fruits4.jpg" alt="slide" /></div>
        <div class="slide__text">
        <h1>Le traineau</h1>
        <ul >
        <li style="color: blue;"><img class="slide__icon" src="public/img/slider/fruits4.jpg" alt="HTML structure" /> <a href="index.php">Voyage au Canada</a></li>
        <li style="color: red;"><img class="slide__icon" src="public/img/slider/fruits4.jpg" alt="HTML structure" /> <a href="index.php">Une jolie montre</a></li>
        <li style="color: green;"><img class="slide__icon" src="public/img/slider/fruits5.jpg" alt="HTML structure" /> <a href="index.php">Voyage aux USA</a></li>
        </ul>
        <form  method="post" action="commande.php">
        <input class="slide__button" type="submit" value="j'en profite" /></form>
        </div>
        <div><img class="slide__img" src="public/img/slider/fruits5.jpg" alt="slide" /></div>
    </div>
    
    </div>
</div>

<!-- appel de l'application shop --> 
<?php require_once("netricite/view/shop/shopIndex.php"); ?>

<script src="public/js/slider.js"></script>
