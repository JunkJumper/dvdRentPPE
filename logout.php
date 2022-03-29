<?php
// détruit la session et rappelle la page appelante
// ne fait aucun affichage
session_start();
$_SESSION =array(); // réinitialise tt les variables de session array vide
session_destroy();
$cible=$_SERVER['HTTP_REFERER']; // url de la page dont on vient
header("location:".$cible."");  // et on y retourne
?>