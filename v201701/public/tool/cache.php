<?php // On utilise ici la date de modification du fichier 
// comme référence mais on peut utiliser une autre donnée
$file = __FILE__;
$last_modified_time = filemtime($file);

// On génère l'ETAG faible
$etag = 'W/"' . md5($last_modified_time) . '"';
fwTrace( debug_backtrace(),array( "$file" =>  gmdate( 'D, d M Y H:i:s', $last_modified_time ),
    "ETAG"=>$etag ) );

// On définit les bons headers
header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $last_modified_time) . " GMT");
header('Cache-Control: public, max-age=604800'); // On peut ici changer la durée de validité du cache
header("Etag: $etag");

// On vérifie les headers envoyés dans la requête
if (
(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $last_modified_time) ||
(isset($_SERVER['HTTP_IF_NONE_MATCH']) && $etag === trim($_SERVER['HTTP_IF_NONE_MATCH']))
) {
    fwTrace(debug_backtrace(),array("vFooter.cache" =>  "HTTP/1.1 304 Not Modified" ));
    // On renvoit une 304 si on n'a rien modifié depuis
    header('HTTP/1.1 304 Not Modified');
    exit();
}
if (!isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) fwTrace( debug_backtrace(),array( "vTemplate.cache" =>  "modified empty"));
    else fwTrace( debug_backtrace(),array( "vFooter.cache" =>  "page has been reloaded",  
    "MODIFIED"=>$_SERVER['HTTP_IF_MODIFIED_SINCE'] ) );
if (!isset($_SERVER['HTTP_IF_NONE_MATCH'])) fwTrace( debug_backtrace(),array( "vTemplate.cache" =>  "none empty"));
    else fwTrace(debug_backtrace(),array("vFooter.cache" =>  "page has been reloaded", 
    "NONE"=> $_SERVER['HTTP_IF_NONE_MATCH']));
?>