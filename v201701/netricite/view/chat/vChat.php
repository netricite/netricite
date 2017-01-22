<?php $this->title = "Netricite - Chat" ?>

<?php require_once("netricite/view/vViewInit.php"); ?>   	
   
<?php
    echo "<div class='row chat'>";
    //echo $this->formgen->rowbegin();
    echo $this->formgen->divbegin("11");
    ?>
    <div id="chatMessage">
        
    <?php foreach ($records as $record):
    $timestamp = new DateTime($record['date_created']);
    if ($this->cleanup($record['sender']) == $pseudo) {
        $messageClass="chat__from";
            }  else {
        $messageClass="chat__from chat__to";
    }
    ?>
    		
    		<p class="<?= $messageClass?>"><?= "<font size='0.7'>" .
                "(" . $record['id'] . ') ' . $timestamp->format("Y-m-d H:i:s") . "</font> - " . htmlutf8($record['sender']) . ' -> ' .'<strong> ' 
                . htmlutf8($record['destinee']) . '</strong> : ' 
                . htmlutf8($record['message']) 
                ?>
                </p>
        	<?php endforeach; ?>
            </div>
<?php
    echo $this->formgen->divend();
    echo $this->formgen->divbegin("1");
    echo    '<div class="chat__users">connected: </br>jp </br> gg </br></div>';
    echo $this->formgen->divend();
    ?>
    <span id="statusResponse"> </span>
    <select id="chatStatusSelect"  name="status"   onchange="setStatus(this)">
    <option value="0">AFK</option>
    <option value="1">Busy</option>
    <option value="2" selected>Online</option>
    </select>
    <div class="chat--loading">
            <center>
                <span >Loading messages...</span><br />
                <img src="ajax-loader.gif" alt="Please wait...">
            </center>
        </div>
    <div id="chatInfo"></div>
<?php
    echo $this->formgen->divend();
    echo $this->formgen->rowend();
?>

<?php
    echo $this->formgen->formbegin(array("name"=>"formChat"),
        array("application"=>"chat", "class"=>"chat"),
        array("destinee"=>"", "message"=>""));
    echo "<fieldset>";
    echo $this->formgen->input(array("field"=>"destinee", "id"=>"pseudo", "placeholder"=>"Saisir le destinataire", "label"=>"Destinataire", "errortext"=>"pseudo minimum 2 characters",
        "attr"=>array("required" => "required", "autofocus" => "autofocus" )
    ));
    echo $this->formgen->textarea(array("field"=>"message", "placeholder"=>"Saississez votre message", "label"=>"Message",
        "attr"=>array("required" => "required")
    ));
    //echo $this->formgen->input("destinee","", "Saisir le destinataire","","Destinataire" , "", array("required" => "required"));
    //echo $this->formgen->textarea("", "message", "Saississez votre message","12");

    echo $this->formgen->hidden("sender", "$user");
    echo $this->formgen->hidden("date_created", "$date");
    echo $this->formgen->hiddenNodata("action", "publish");
	
    echo $this->formgen->button(array("field"=>"send","col"=>"12","icon"=>"transfer","text"=>"Envoyer"));
    /*
	if (!empty($_SESSION['pseudo'])) {
	    echo $this->formgen->button(array("field"=>"send","col"=>"12","icon"=>"transfer","text"=>"Envoyer"));
	    //echo $this->formgen->button("send","12","transfer","","Envoyer");
	} else {
	    echo $this->formgen->button(array("field"=>"send","col"=>"12","icon"=>"ban-circle","class"=>"pull-right","text"=>"Envoyer", array("disabled"=>"disabled")));
	    //echo $this->formgen->button("send","12","ban-circle","pull-right", "Envoyer", array("disabled"=>"disabled"));
	};
	*/
	echo "<fieldset>";
	echo $this->formgen->formend();
    ?>
