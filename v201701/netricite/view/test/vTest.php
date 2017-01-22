<?php require_once("netricite/view/vViewInit.php"); ?>   
<a class="pull-right" href="index.php?application=root&class=root#myPage">Acceuil</a>

<?php $this->title = "test" ;
use Netricite\Framework as fw;
use Netricite\Payment as payment;

$this->formgen = new fw\fwFormGen();

echo $this->formgen->formbegin(array("name"=>"formPayment","col"=>"12","legend"=>"Effectuer le paiment"),
    array("application"=>"test","class"=>"test"),
    array());
//echo '<form name="formPayment" action="index.php?application=test&class=test" method="post" >';
echo $this->formgen->hiddenNodata("action", "payment");
//echo '<button id="save" type="submit" name="save">Payment</button>';
echo $this->formgen->button(array("field"=>"payment", "col"=>"3","icon"=>"credit-card","text"=>"Continue to secure payment", "tooltip"=>"Altapay secure payment"));

echo '<form id="PensioPaymentForm" >';
echo "All content in here will be replaced by the actual payment form";
echo "</form>";

if (!empty($_POST)) {
    appWatch($_POST,"response from altapay","vTest");
    
} 

?>

 