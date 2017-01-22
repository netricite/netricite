<?php require_once("netricite/view/vViewInit.php"); ?>   
<?php $this->title = "To Do list" ?>
<h1>Listes des taches groupées par catégorie</h1>

<?php
echo $this->formgen->rowbegin();

    echo "<ul id='sortable__index'>";
        $i=0;
        foreach ($classes as $record) {
            $i++;
            echo $this->formgen->divbegin("2");
            echo '<li id="' . $record['type'] . '">';
            echo '<span class="sortable__index glyphicon glyphicon-menu-hamburger"></span>';
            echo '<span>' . $record['type'] . '</span> ';         
            echo '</li>';
            echo $this->formgen->divend();
        }
    echo "</ul>";
    if (isset($_SESSION['todoClass']) && isset($_SESSION['pseudo']) ) {
        $todoClass=$_SESSION['todoClass'];
    } else {
        $todoClass="";
    }
echo $this->formgen->divend();
echo $this->formgen->rowend();
?>
    
<?php
echo $this->formgen->rowbegin();
// FORM TODO TASK LIST

echo "<ul id='sortable'>";
    $i=0;
    foreach ($records as $record) {
        $i++;   
        $timestamp = new DateTime($record['milestone']);
        echo "<div class='row' id='" .$record['id']. "' style='background-color:#ecd9c6;border-style:dotted;' >";
        echo "<li  id=row-'" .$record['id']. "' >";
            echo '<span class="sortable glyphicon glyphicon-menu-hamburger">==== tache n. ' .$record['id'].' </span>';
            //echo '<span>'.$record['title'].'</span>';
            /* FORM : TO DO TASK*/
            echo $this->formgen->formbegin(array("name"=>"formTODOlist") ,
                array("application"=>"todo","class"=>"todo"), $record);
                
                echo $this->formgen->input(array("field"=>"title","col"=>"9", "tooltip"=>"tâche"));
                echo $this->formgen->inputDate(array("field"=>"milestone", "index"=>$i, "col"=>"2", "tooltip"=>"délai"));
                
                echo $this->formgen->buttonSession(array("field"=>"operation","icon"=>"ok","value"=>"save", "tooltip"=>"sauvegarder"));
                echo $this->formgen->buttonSession(array("field"=>"operation","icon"=>"trash","value"=>"delete", "tooltip"=>"supprimer"));
                
                echo $this->formgen->input(array("field"=>"note", "col"=>"12", "tooltip"=>"note"));
                
                echo $this->formgen->hidden("user", "$user");
                echo $this->formgen->hiddenData("id", "id");
                echo $this->formgen->hiddenNodata("action", "updateDelete");
            echo $this->formgen->formend();
        echo "</li>";
        echo $this->formgen->rowend();
    }
echo "</ul>";
echo $this->formgen->rowend();
?>

<?php 
echo $this->formgen->rowbegin();
/* FORM : NEW TODO TASK */
    echo $this->formgen->formbegin(array("name"=>"formTODOtask"),
        array("application"=>"todo","class"=>"todo"),
        array("title"=>"", "milestone"=>date('Y-m-d H:i:s'), "note" =>"", "type"=> $todoClass));
        echo "<fieldset>";
        echo "<legend>Nouvelle Tache</legend>";
            echo $this->formgen->input(array("field"=>"title", "placeholder"=>"Saisissez une nouvelle tâche", "errortext"=>"saisie invalide", "label"=>"Tâche",
                "attr"=>array("required" => "required")));
            
            echo $this->formgen->input(array("field"=>"note", "placeholder"=>"note facultative", "errortext"=>"saisie invalide", "label"=>"note"));
            echo $this->formgen->inputDate(array("field"=>"milestone", "placeholder"=>"Fin prévue le", "errortext"=>"saisie invalide", "label"=>"Délai", "col"=>"6"));
            echo $this->formgen->input(array("field"=>"type", "placeholder"=>"type", "errortext"=>"saisie invalide", "label"=>"Catégorie", "col"=>"6"));
            
            echo $this->formgen->hidden("user", "$user");
            echo $this->formgen->hidden("status", "0");
            echo $this->formgen->hiddenNodata("action", "save");
            
            echo $this->formgen->buttonSession(array("field"=>"save","col"=>"12","icon"=>"plus-sign","text"=>"Ajouter une tâche"));

        echo "<fieldset>";
    echo $this->formgen->formend();
echo $this->formgen->rowend();

?>

