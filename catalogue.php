<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Catalogue Coverflow affiches des films</title>

<!-- cette page permet de consulter toutes les affiches des films en mode coverflow. -->
<link rel="stylesheet" href="css/imageflow.css" type="text/css" />
<link href="css/bluraycss.css" rel="stylesheet" type="text/css"> 
<script type="text/javascript" src="jscripts/imageflow.js"></script> 
</head>

<body>

<div class="container">
  <div class="header">
  	<?php require "includes/entete.php"; //ajoute le menu d'authentification ?> 
  </div><!-- end .header -->
  <div class="sidebar1">
  <?php require "includes/sidebar1.ssi"; ?> 
  </div>
  <div class="content">
    <h1>Catalogue des Films </h1>
	<div id="myImageFlow" class="imageflow" background-color="#000000">
<?php
require "includes/connectbdd.php";
$query="SELECT ID_film, Titre, URI_Affiche FROM t_films";
$result=$connexion->query($query) or die("echec de la requête");
if ($result->num_rows > 0)
	{	
		while ($ligne = $result->fetch_assoc()) 
 			{
				if(empty($ligne['URI_Affiche'])) 
					{
						$ligne['URI_Affiche']="Images/Affiche/default.jpg";
					}
				else
					{ // mettre les slashes à l'endroit
					$ligne['URI_Affiche']= str_replace("\\","/",$ligne['URI_Affiche']);
					// constuire chaque élément du coverflow
					echo "\n <img src=\"". $ligne['URI_Affiche']."\"". " longdesc=\"fichefilm.php?ID=".$ligne['ID_film']. "\"".
					"width=\"420\" height=\"630\" alt=\"".$ligne['Titre']."\" />";
					}
			}
	}
else
	{
		echo "aucun résultat";
	}
$connexion->close();
?>
	</div>
  </div>    <!-- end .content -->
  <div class="footer">
   <?php require_once "includes/footer.ssi"; ?>
   </div><!-- end .footer -->
</div><!-- end .container -->
</body>
</html>