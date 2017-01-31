<?php require("netricite/view/vViewInit.php");
use Netricite\Framework as fw;
?>
<?php $this->title = "Mes commandes"; ?>	

        <!-- Container (section1 Section) -->
        <article id="section1" class="container-fluid">
            <header class="panel-heading">
            	<h1 class="text-center">Mes commandes</h1>
            </header>
            
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#tab0">Commandes</a></li>
              <li><a data-toggle="tab" href="#tab1">Commandes en cours</a></li>
              <li><a data-toggle="tab" href="#tab2">Commande annulées</a></li>
            </ul>
            
            <div class="tab-content">
              <div id="tab0" class="tab-pane fade in active">
                
                <table class="table">
                    <tr class="cart">
                        <th class="cart">N° de commande</th>
                        <th class="cart">Commande effectuée le</th>
                        <th class="cart">Total</th>
                        <th class="cart">Livraison à </th>
                        <th class="cart">Référence</th>
                    </tr>
                <?php 
           
                echo count($data) . " commandes passées à ce jour";
                foreach ($data as $order) {
                    echo "<tr>";
                        echo "<td><div>" . str_pad($order['id'], 8, '0', STR_PAD_LEFT) . "</div></td>";
                        $date = strtotime($order['date_created']);
                        echo "<td><div>" . date('d/m/Y h:m:s', $date) . "</div></td>";
                        echo "<td><div>" . number_format($order['netamount'],2,',',' '). "</div></td>";
                        echo "<td><div>" . $userdata['firstname'] ." ". $userdata['lastname'] . "</div></td>";
                        echo "<td><div>" . $order['reference']. "</div></td>"; 
                    echo "</tr>"; 
                    
                    echo "<tr>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td><div><a href='index.php?application=shop&class=order&action=detail&id=" . $order['id'] ."'>Détail de la commande</a>". "</div></td>";
                        echo "<td><div><a href='index.php?application=shop&class=order&action=invoice&id=" . $order['id'] ."'>Facture</a>". "</div></td>";
                    echo "</tr>";
                }
                     
                ?>
                </table>
              </div>
              
              <div id="tab1" class="tab-pane fade">
               
                
              </div>
              
              <div id="tab2" class="tab-pane fade">
              
               
              </div>

            </div>        <!-- end tab-content --> 
           
        	
    </article>

