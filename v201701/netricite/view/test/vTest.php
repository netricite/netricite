<?php require_once("netricite/view/vViewInit.php"); ?>
<a class="pull-right"
	href="index.php?application=root&class=root#myPage">Acceuil</a>

<?php

$this->title = "test";
use Netricite\Framework as fw;
use Netricite\Payment as payment;

?>
<section class="container">
	<div class="row">
		<ul id="sortable" class="sortable">
			<div class="col-xs-2 col-sm-2">
				<li><span class="fa fa-heart"></span>Item 1</li>
			</div>
			<div class="col-xs-2 col-sm-2">
				<li><span class="fa fa-heart"></span>Item 2</li>
			</div>
			<div class="col-xs-2 col-sm-2">
				<li><span class="fa fa-heart"></span>Item 3</li>
			</div>
			<div class="col-xs-2 col-sm-2">
				<li><span class="fa fa-heart"></span>Item 4</li>
			</div>
			<div class="col-xs-2 col-sm-2">
				<li><span class="fa fa-heart"></span>Item 5</li>
			</div>
			<div class="col-xs-2 col-sm-2">
				<li><span class="fa fa-heart"></span>Item 6</li>
			</div>
			<div class="col-xs-2 col-sm-2">
				<li><span class="fa fa-heart"></span>Item 7</li>
			</div>
		</ul>
		<div>
			<aside class="panel">
				<h3 class="text-center">pour nous trouver aux Gets</h3>
				<p>Rue du centre, en face de la patinoire(place limonaire), au
					centre du Village des Gets</p>
				<div id="googleMap"></div>

			</aside>

</section>
<p id="jsLoaded">DOM not yet loaded</p>





