<?php require_once("netricite/view/vViewInit.php"); ?>   	
<?php $this->title = "My Blog - Post comments" ?>	
<?php
	$timestamp = new DateTime($data['blog']['date_created']);
	?>
	
<header>
	<div class="pull-right">
        <a  href="<?= "index.php?application=blog&class=blog" ?>">retour aux blogs
        </a></div>
    <h3><strong>BLOG</strong> - <?= htmlutf8($data['blog']['blog']) ?> </h3>
	<h3><strong>POST</strong> - <?= htmlutf8($data['post']['post']) ?> </h3>
	 contenu du post : <?= htmlutf8($data['post']['content']) ?></h3>	
</header>

<?php
    echo $this->formgen->accordionbegin("Modifier le post <i>'". htmlutf8($data['post']['post']) . "'</i>");
    echo $this->formgen->formbegin(array("name"=>"formPost"),
        array("application"=>"blog","class"=>"post"), 
        $data['post']);

    echo $this->formgen->input(array("field"=>"post", "placeholder"=>"Titre du post", "errortext"=>"saisie invalide", "label"=>"Titre",
        "attr"=>array("required" => "required" )));
    echo $this->formgen->textarea(array("field"=>"content", "placeholder"=>"Description du contenu du post", "label"=>"Description",
        "attr"=>array("required" => "required" )));
    
    echo $this->formgen->hiddenData("id", "id");
    echo $this->formgen->hidden("user", "$user");
    //echo $this->formgen->hidden("date_created", "$date;");
    echo $this->formgen->hiddenNodata("action", "save");
    
    echo $this->formgen->buttonSession(array("field"=>"add","col"=>"12","icon"=>"ok","text"=>"Modifier le post"));
    /*
    if (!empty($_SESSION['pseudo']) && $_SESSION['pseudo'] = $data['blog']['user']) {
        echo $this->formgen->button(array("field"=>"add","col"=>"12","icon"=>"ok","text"=>"Modifier le post"));
    } else {
        echo $this->formgen->button(array("field"=>"add","col"=>"12","icon"=>"ban-circle","class"=>"pull-right","text"=>"Ajouter un post", array("disabled"=>"disabled")));
    };
    */
    echo $this->formgen->formend();
    echo $this->formgen->accordionend();
?>
	
    <hr />          

 <legend>Ajouter votre commentaire</legend>
 <?php
    echo $this->formgen->formbegin(array("name"=>"formComment"),
        array("application"=>"blog","class"=>"comment"), 
        array("post"=>"", "comment"=>"", "user"=>"", "date_created"=>"", "postid"=>""));

    echo $this->formgen->textarea(array("field"=>"comment", "placeholder"=>"Votre commentaire sur ce post", "label"=>"commentaire",
        "attr"=>array("required" => "required" , "autofocus" => "autofocus" )));
    
    echo $this->formgen->hidden("user", "$user");
    //echo $this->formgen->hidden("date_created", "$date");
    $postid=$data['post']['id'];
    echo $this->formgen->hidden("postid", "$postid");
    echo $this->formgen->hiddenNodata("action", "save");
    
    if (!empty($_SESSION['pseudo']) ) {
        echo $this->formgen->button(array("field"=>"add","col"=>"12","icon"=>"ok","text"=>"Publier le commentaire"));
    } else {
        echo $this->formgen->button(array("field"=>"add","col"=>"12","icon"=>"ban-circle","class"=>"pull-right","text"=>"Publier le commentaire", array("disabled"=>"disabled")));
    };
    echo $this->formgen->formend();

?>


<h1 style="text-align:center"> commentaires du POST</h1>
<hr />

<div>
    <?php foreach ($data['comments'] as $comment): 
	$timestamp = new DateTime($comment['date_created']);
	?>
    <p ><?= "[" . htmlutf8($comment['user']) . "]"  ?> commenté le <time class=time><?= $timestamp->format("Y-m-d H:i:s") ?></time> </p>
    <p ><?= htmlutf8($comment['comment']) ?></p>
    <hr />
	<?php endforeach; ?>
</div>

<div class="page__filler"><i>Fin des commentaires</i></div>

	
