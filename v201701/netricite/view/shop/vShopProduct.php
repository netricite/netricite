 <?php $this->title = "Shopping" ?>

<header>
<h1 class="title--emphasis">Produits savoyards</h1>
</header>	

<?php
// --------------------------------
// create a new column
function newCol($item, $count, $htmlStatement, $param1)
{        
        echo "item=" . $item . " ";
        echo "count=" . $count . " ";
        echo "<br>";
        if ($item<$count) {
            echo "item=" . $item . " ";
            echo $htmlStatement . $this->cleanup($product[$item][$param1]);
            echo '</td>';
        } else { // empty row
            echo " no item=" . $item . " ";
           echo "<td>&nbsp;</td>";
		} 
}?>		 

<?php  
// -------------------------------- 
// store the records in a table
$i=0;
foreach ( $records as $record ) {
        $product[$i] = $record;
	$i++;
}

?>

<table  cellspacing="30" > 

<?php
$count=count($product);
$nbColumn=5;
for ($i = 0; $i < $count; $i+=$nbColumn) {
    ?>          		          
    <tbody> 
 
        <tr>
        <?php for ($col = 0; $col < $nbColumn; $col++) {
            if ($i+$col<$count) {
                echo '<td class="shop"><a href="index.php?application=shop&class=shopDetail&id="' . $product[$i+$col]['id'] . '</a>';
                echo $this->cleanup($product[$i+$col]['shortname']);
                echo '</td>';
        	} else { // empty row
        	     
        	    echo "<td>&nbsp;</td>";
        	}
            }?> 	
        </tr>
        		
		<tr>
		<?php for ($col = 0; $col < $nbColumn; $col++) {
		    if ($i+$col<$count) {
		        echo '<td><div>' ;  
		        echo $this->cleanup($product[$i+$col]['name']);
    	        echo '</td>';
        	} else { // empty row
        	     
        	    echo "<td>&nbsp;</td>";
        	}
            }?> 	
        </tr>
               
        <tr>
        <?php for ($col = 0; $col < $nbColumn; $col++) {
            if ($i+$col<$count) {
                echo '<td><div>' ;
                echo $this->cleanup($product[$i+$col]['description']);
                echo '</td>';
        	} else { // empty row
        	     
        	    echo "<td>&nbsp;</td>";
        	}
            }?> 	 			
        </tr>	
        		
        <tr>
        <?php for ($col = 0; $col < $nbColumn; $col++) {
            if ($i+$col<$count) {
                echo '<td><div>';
                echo "La piece  " . $this->cleanup($product[$i+$col]['unitPrice']) . "&euro;";
        	    echo '</td>';
        	} else { // empty row
        	     
        	    echo "<td>&nbsp;</td>";
        	}
            }?> 	
        </tr>
        			      
        <tr>
        <?php for ($col = 0; $col < $nbColumn; $col++) {	
            if ($i+$col<$count) {
                echo '<td class="shop"><div class="polaroid">';
        	    echo '<img class="shop" src="' . $product[$i+$col]['imgLink'] . '" alt="' . $product[$i+$col]['shortname']. '" height="100" />';
        	    echo '<div class="shop"><p>' ;
        	    echo $this->cleanup($product[$i+$col]['shortname']) ;
        	    echo '</p></div></div>' ;
                echo '</td>';
            } else { // empty row
                 
                echo "<td>&nbsp;</td>";
            }
            }?>   
		</tr>
               
        <tr>
        <?php for ($col = 0; $col < $nbColumn; $col++) {
            if ($i+$col<$count) {
             ?> 
                <td class="shop">
                <div class="tooltip">
               <a  href="<?= "index.php?application=shop&class=cart&action=add&id=" . $product[$i+$col]['id'] ?> " > 
               <img src="public/img/cart.png" alt="Ajouter au panier" height="30" />
               </a> 
               <span class="tooltiptext">Ajouter au panier</span>
				</div> 
                </td>
            <?php } else { // empty row                
                echo "<td>&nbsp;</td>";
            }
            }?>              			
        </tr>            			
          
    </tbody>
        
<?php }; ?>

</table>

  

        

		 