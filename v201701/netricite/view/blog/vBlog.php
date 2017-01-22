<?php require_once("netricite/view/vViewInit.php"); ?>   	
<?php $this->title = "My Blog - Posts" ?>
 	
<div class="pull-right">
    <a  href="index.php?application=blog&class=admin">Blog statistics (reserved to administrator)</a>
</div>
	<button class="accordion">Ajouter un nouveau blog</button>
	<div class="panel">

	<?php
	echo $this->formgen->accordionbegin("Ajouter un nouveau blog");
	echo $this->formgen->formbegin(array("name"=>"formBlog"),
	   array("application"=>"blog","class"=>"blog"), 
	   array("blog"=>"", "content"=>""));

	echo $this->formgen->input(array("field"=>"blog", "placeholder"=>"Titre du blog", "errortext"=>"saisie invalide", "label"=>"Titre", 
	    "attr"=>array("required" => "required", "autofocus" => "autofocus" )));
	echo $this->formgen->textarea(array("field"=>"content", "placeholder"=>"Description du contenu du blog", "label"=>"Description"));
	
	echo $this->formgen->hidden("user", "$user");
	//echo $this->formgen->hidden("date_created", "$date;");
	echo $this->formgen->hiddenNodata("action", "save");
	
	echo $this->formgen->button(array("field"=>"add","col"=>"12","icon"=>"ok","text"=>"ajouter un blog"));
	/*
	if (!empty($_SESSION['pseudo'])) {
	    echo $this->formgen->button(array("field"=>"add","col"=>"12","icon"=>"ok","text"=>"ajouter un blog"));
	} else {
	    echo $this->formgen->button(array("field"=>"add","col"=>"12","icon"=>"ban-circle","class"=>"pull-right","text"=>"ajouter un blog", array("disabled"=>"disabled")));
	};
	*/
	echo $this->formgen->formend();
	echo $this->formgen->accordionend();
    ?>

	<hr>
</div>

<div >
    <h1 class="title--emphasis"> Blogs ouverts</h1>
    <hr>

	<?php foreach ($data as $record):
		$timestamp = new DateTime($record['date_created']);
    ?>
    <div>      
            <a href="<?= "index.php?application=blog&class=post&blogid=" . $record['id'] ?>">
                <p ><?= htmlutf8($record['blog']) ?></p>
            </a>
            <time class=time><?= $timestamp->format("Y-m-d H:i:s") ?></time>
            [ <?= htmlutf8($record['user'])?> ]

        <p><?= htmlutf8($record['content']) ?></p>
        <hr />
     </div>
<?php endforeach; ?>
</div>