<?php 
$this->title = "My Blog - Post details";
$timestamp = new DateTime($data['blog']['date_created']);
 ?>

<?php require_once("netricite/view/vViewInit.php"); ?>   	

<header>
	<div class="pull-right">
        <a  href="<?= "index.php?application=blog&class=blog" ?>">retour aux blogs</a>
    </div>
    <h3 >BLOG - <?= htmlutf8($data['blog']['blog']) ?></h3>
    <p ><?= htmlutf8($data['blog']['content']) ?> - <?= "[" . htmlutf8($data['blog']['user']) . "]"  ?> le <time class=time><?= $timestamp->format("Y-m-d H:i:s") ?></time> 
    </p>
    <hr />
</header>
 
<?php
    echo $this->formgen->accordionbegin("Modifier le blog <i>'". htmlutf8($data['blog']['blog']) . "'</i>");
// FORM = BLOG UPDATE
    echo $this->formgen->formbegin(array("name"=>"formPost"),
	   array("application"=>"blog","class"=>"blog"), 
       $data['blog']);
    echo $this->formgen->input(array("field"=>"blog", "placeholder"=>"Titre du blog", "errortext"=>"saisie invalide", "label"=>"Titre",
        "attr"=>array("required" => "required")));
    echo $this->formgen->textarea(array("field"=>"content", "placeholder"=>"Description du contenu du blog", "label"=>"Description"));

	echo $this->formgen->hiddenData("user", "$user");
	//echo $this->formgen->hiddenData("date_created", "$date");
	echo $this->formgen->hiddenData("id", "id");
	echo $this->formgen->hiddenNodata("action", "save");
	
	echo $this->formgen->buttonSession(array("field"=>"add","col"=>"12","icon"=>"ok","text"=>"Modifier le blog"));
	/*
	if (!empty($_SESSION['pseudo']) && $_SESSION['pseudo'] = $data['blog']['user']) {
	    echo $this->formgen->button(array("field"=>"add","col"=>"12","icon"=>"ok","text"=>"Modifier le blog"));
	} else {
	    echo $this->formgen->button(array("field"=>"add","col"=>"12","icon"=>"ban-circle","class"=>"pull-right","text"=>"Modifier le blog", array("disabled"=>"disabled")));     
	};
	*/
	echo $this->formgen->formend();
	echo $this->formgen->accordionend();
    ?>
<h1 class="title--emphasis"> Posts ouverts</h1>
<hr />		

<div>

<?php 
// LIST OF POSTS
    foreach ($data['posts'] as $post): 
	$timestamp = new DateTime($post['date_created']);
	?>
	<a href="<?= "index.php?application=blog&class=comment&postid=" . $post['id'] ?>">
                <p class="headerPost">POST - <?= htmlutf8($post['post']) ?></p>
            </a>
    <p ><?= "[" . htmlutf8($post['user']) . "]"  ?> le <time class=time><?= $timestamp->format("Y-m-d H:i:s") ?></time> </p>
    <p ><?= $post['content'] ?></p>
    <hr />
<?php endforeach; ?>
</div> 

<h1 class="title--emphasis"> Ajouter un post au blog <i>" <?= $blog['blog'] ?>"</i></h2>
<hr />		

<?php
// form = ADD A POST
    echo $this->formgen->formbegin(array("name"=>"formPost"), 
        array("application"=>"blog","class"=>"post"), 
        array("post"=>"", "content"=>"", "user"=>"", "date_created"=>"", "blogid"=>""));

    echo $this->formgen->input(array("field"=>"post", "placeholder"=>"Titre du post", "errortext"=>"saisie invalide", "label"=>"Titre",
        "attr"=>array("required" => "required", "autofocus" => "autofocus" )));
    echo $this->formgen->textarea(array("field"=>"content", "placeholder"=>"Description du contenu du post", "label"=>"Description"));
    
	$blogid=$data['blog']['id'];
	echo $this->formgen->hidden("user", "$user");
	//echo $this->formgen->hidden("date_created", "$date");
	echo $this->formgen->hidden("blogid", "$blogid");
	echo $this->formgen->hiddenNodata("action", "save");

	
	if (!empty($_SESSION['pseudo'])) {
	    echo $this->formgen->button(array("field"=>"add","col"=>"12","icon"=>"ok","text"=>"Ajouter un post"));
	} else {
	    echo $this->formgen->button(array("field"=>"add","col"=>"12","icon"=>"ban-circle","class"=>"pull-right","text"=>"Ajouter un post", array("disabled"=>"disabled")));
	};
	echo $this->formgen->formend();
    ?>

<div class="page__filler"></div>



