<?php
	
	include_once('model/chat/insertRecord.php');
	
	if (isset($_POST['destinee']) and isset($_SESSION['pseudo'])) 
			{
			
				$date = date('Y-m-d H:i:s');
				insertRecord($_SESSION['pseudo'], 
				$_POST['destinee'],
				0,
				0,
				"contacted by X",
				$date
				);

			}
			?>