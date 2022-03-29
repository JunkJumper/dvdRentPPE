<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>BluRayClub liste des films</title>
<link href="css/bluraycss.css" rel="stylesheet" type="text/css">
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
    <h1>Liste de Bandes-Annonces des Films </h1>
    <div class="scrollable" style="height:450px;">
<?php
require "includes/connectbdd.php";
$query="SELECT ID_film, Titre, Studio, Réalisateur, URL_BA FROM t_films WHERE Support LIKE 'Blu%' And URL_BA !=''";
// echo $query;
$result=$connexion->query($query) or die("echec de la requête");

if ($result->num_rows > 0)
	{
//  		echo "<H3>Réponse de la bdd :</H3>";
		echo "<p align=\"left\">";
 		while ($ligne = $result->fetch_assoc()) 
 			{
				// constuire appel de la fiche film avec le ID du film en paramètre
				echo '<a href="'.$ligne['URL_BA'].'\"target="_blank">'.'Bande Annonce du film : <b>'.$ligne['Titre'].' '.'</b></a>';
				echo "  -->  ".'<a href="fichefilm.php?ID='.$ligne['ID_film'].'"> ( Voir la fiche : '.$ligne['ID_film'].')</a><br>';
			}
		echo "</p>";
	}
else
	{
		echo "aucun résultat";
	}
$connexion->close();
?>
	</div> <!-- end list des films -->
</div>    <!-- end .content -->
    <div class="footer">
    <?php require "includes/footer.ssi"; ?>  
    </div>
  <!-- end .container --></div>
</body>
</html>