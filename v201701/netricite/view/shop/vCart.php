<?php require("netricite/view/vViewInit.php"); ?>   	
<?php $this->title = 'Mon Magasin <span style="font-weight:italic; color:#F7F2E0">Le traineau</span> - Les Gets - Haute Savoie' ;?>       
    
<!-- PayPal Logo -->
<table border="0" cellpadding="10" cellspacing="0" align="center">
<tr><td align="center"></td></tr><tr><td align="center">
<a href="https://www.paypal.com/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;">
<img src="https://www.paypalobjects.com/webstatic/mktg/logo/bdg_now_accepting_pp_2line_w.png" border="0" alt="Now Accepting PayPal"></a>
<div style="text-align:center">
<a href="https://www.paypal.com/webapps/mpp/how-paypal-works"><font size="2" face="Arial" color="#0079CD">How PayPal Works</font></a>
</div>
</td></tr>
</table>
<!-- PayPal Logo -->

<?php
use Netricite\Framework as fw;
echo $this->formgen->formbegin(array("name"=>"formCart", "legend"=>"Mon panier"),  
                array("application"=>"shop","class"=>"order"), 
                array());
?>          
<table class="table">
    <tr class="cart">
    <th class="cart"></th>
    <th class="cart">Produit</th>
    <th class="cart">Article</th>
    <th class="cart">Qte</th>
    <th class="cart">PU</th>
    <th class="cart">Montant HT</th>
    <th class="cart">Montant TTC</th>
    <th class="cart">Supprimer</th>
</tr>
	
 <?php 
    $grossAmount=0;
    //var_dump($_SESSION['cart']);
    //var_dump($data);
    foreach ($data as $item){
        $quantity=$_SESSION['cart'][$item['id']];
        
	?>
<tr class="cart">
    <td class="cart"><?php echo $this->formgen->image(array("file"=>$item['imgLink'], "tooltip"=>$item['name'], "boxsize"=>53)); ?></td>
    <td class="cart productName"><div><?= $item['name']; ?></div></td>
    <td class="cart"><div><?= $item['id']; ?> </div></td>
    <td class="cart"><div><?= $quantity; ?> </div></td>
         <td class="cart"><div><?= $item['unitPrice']; ?> &euro;</div></td>
    <td class="cart"><div><?= number_format($item['unitPrice'] * $quantity,2,',',' '); ?> &euro;</div></td>
    <td class="cart"><div><?= number_format($item['unitPrice'] * $quantity * 1.196 ,2,',',' '); ?> &euro;</div></td>
    <td class="cart"><div>
    				<a href="<?= "index.php?application=shop&class=cart&action=remove&id=" . $item['id'] ?> "><img class="btn btn-primary" src="public/img/delete.png"></a> 
    			</div></td>
    
</tr>
  
<?php 
        $grossAmount+=$item['unitPrice'] * $quantity;
    }
    $_SESSION['order']['grossamount']=$grossAmount  ;
    $_SESSION['order']['netamount']=$grossAmount * 1.196 ;
    $_SESSION['order']['tax']=$_SESSION['order']['netamount'] - $grossAmount ;
    $_SESSION['order']["currency"]=fw\fwConfiguration::get('company.currency');
    $_SESSION['order']["shipment"]=0;
    ?>
 
  	<tr class="cart">
  	<th class="cart"></th>
    <th  >Total</th>
    <th class="cart">&nbsp; </th>
    <th class="cart"><?= number_format(array_sum($_SESSION['cart']),0,',',' ') ?> </th>
    <th class="cart">&nbsp; </th>
    <th class="cart"><?= number_format($grossAmount,2,',',' ') ?>&euro;</th>
    <th class="cart"><?= number_format($_SESSION['order']['netamount'],2,',',' ') ?>&euro;</th>

    <th><script type="text/javascript" data-pp-pubid="79be1ab867" data-pp-placementtype="120x240"> (function (d, t) {
"use strict";
var s = d.getElementsByTagName(t)[0], n = d.createElement(t);
n.src = "//paypal.adtag.where.com/merchant.js";
s.parentNode.insertBefore(n, s);
}(document, "script"));
</script></th>
  	</tr>

<tr class="cart">
<th class="cart"><a class="cart" href='index.php?application=shop&class=shop'>Continuer vos achats</br></a></th>
<th class="cart"></th>
<th class="cart"></th>
<th class="cart"></th>
<th class="cart"><?php 	
	echo $this->formgen->hiddenNodata("action", "payment");
	
	?></th>
<th class="cart"><?php 	

	echo $this->formgen->button(array("field"=>"payment","col"=>"12","icon"=>"ok","text"=>"Commander", "tooltip"=>"paiement sécurisé"));
	?></th>
</tr>
	</table>
	


	
	
	<!--  Display invoice: same window -->
	<!-- <iframe src='netricite/report/shop/invoice.php?id=invoice'  width='1000' height='1500'></iframe>  -->

	<!--  Display invoice: separate window -->
	<p><a href='index.php?application=shop&class=order&action=invoice' target='_blank' class='pull-left'>Visualiser votre dernière facture</a></p>








              