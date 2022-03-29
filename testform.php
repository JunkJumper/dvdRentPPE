<H1>TEST De reception des param&egrave;tres du formulaire</H1>
<link href="css/bluraycss.css" rel="stylesheet" type="text/css"> 

<?php
echo '<div class="loginbox">';
echo '<TABLE class="blueTable">';
foreach($_POST as $param => $valeur)
	{ 
	echo "<TR>";
	echo '<TD>'.$param. ' </TD><TD> ==></TD><TD>'.$valeur.'</TD>'; 
	echo "</TR>";
	}  
echo '</div>';
?>
