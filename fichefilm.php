<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Fiche d'un Film</title>
<link href="css/bluraycss.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="container">
  <div class="header">
  	<?php require "includes/entete.php"; //ajoute le menu d'authentification ?> 
  </div><!-- end .header -->
  <div class="sidebar1">
  <?php require "includes/sidebar1.ssi"; //ajoute le menu de navigation ?>   
  </div>
  <div class="content">
    
<?php
// On vérifie si la page a été appelée sans Paramètre
if ($_SERVER['QUERY_STRING']=='')
	{ // il faut afficher le formulaire pour obtenir l'ID du film ou des critères de sélection
	echo '<form action="fichefilm.php" method="get">';
	echo '<label>Saisissez le Numéro de film ci-après ...</label>';
	echo '<input name="ID" type="text" value="" size="6" maxlength="5"><br>';
	echo '<input name="valider" type="submit" value="Voir la fiche de ce film">';
	echo '</form>';
		//  le formulaire rappelle la page en lui envoyant les parametres ID et Valider
	}
else		
	{
		$filmid=$_SERVER['QUERY_STRING'];  // on stocke le parametre dans une variable
		// verifier que le parametre est correct, protéger de l'injection SQL
		if (substr($filmid,0,3) !== "ID=")
			{
				echo '<H2>'.'   '.$filmid.'   '.' Parametres transmis Invalides !';	
			}
		else
			{
				// on traite la page avec un numéro de film valide.
				$filmid = $_GET['ID'];  // 
				// echo $filmid;
				require "includes/connectbdd.php";
				$query="SELECT ID_film, Titre, Réalisateur, Année, Miniature, Resume 
				FROM t_films LEFT JOIN resumerfilm ON (t_films.ID_film = resumerfilm.﻿ID_film)
				WHERE t_films.ID_film=".$filmid;
				// echo $query;
				$result=$connexion->query($query) or die('Echec de la requête, <a href="fichefilm.php"> Refaire un essai </a>');
					if ($result->num_rows > 0)
					{
						if(isset($_GET['nc'])) {
							if($_GET['nc'] == true) {
								echo '<h2 class="danger">Vous devez être connecté·e pour emprunter ce film !</h2>';
							}
						}
						echo "<H1>Fiche du film N°".$filmid." :</H1>";
						echo '<table class="blueTable"><TR><TH>ID</TH>
						<TH>Titre</TH><TH>Réalisateur</TH><TH>Année</TH><TH>Miniature</TH><TH>Resume</TH></TR>';
						$fiche = $result->fetch_array();
						
							// préparation pour insertion de la miniature
							$urlmini = str_replace('\\', '/', $fiche['Miniature']);
							// message si absence de résumé
							if (empty($fiche['Resume']))$fiche['Resume']="<p>le résumé pour ce film reste à saisir</p>";
							echo "<TR><TD>".$fiche['ID_film']."</TD>
							<TD>".$fiche['Titre']."</TD>
							<TD>".$fiche['Réalisateur']."</TD>
							<TD>".$fiche['Année']."</TD>
							<TD><img src=\"".$urlmini."\" height=\"250px\"> </TD>
							<TD><div style=\"width:95%;height:250px;overflow-Y:auto;margin:5px;
							padding:3px;text-align:justify\">".$fiche['Resume']."</div></TD>
							</TR>";
							echo "</table><br>";
							// déterminer les actions possibles sur ce film (prêt, échange, vente)
							$sqlstatus = 'SELECT * FROM offrir WHERE IDfilm = "'.$fiche['ID_film'].'";';
							$result2 = $connexion->query($sqlstatus);
							$filmStatus = $result2->fetch_assoc();
							// déterminer si le disque est disponible 
							$sqldispo= "SELECT COUNT(*)AS PasRendu FROM `emprunter` 
							WHERE date_due IS NOT NULL 
							AND date_rendu IS NULL
							AND IDfilm = ".$fiche['ID_film'].";";
							$result3 = $connexion->query($sqldispo);
							$filmdispo = $result3->fetch_array(); // si le film est sorti $filmdispo['PasRendu'] vaut 1 , 0 sinon
							
							
							// affichage des actions possibles (emprunter/acheter/échanger) pour ce BluRay
							echo '<div><nav>';
							echo '<H2 class="compact"> Actions </H2>';
							// insérer ici la liste des actions
							// les actions seront actives ou pas selon les disponibilités du bluray à l'emprunt, l'échange ou la vente.
							// actions Fixes
							echo '<ul>
							<li><a href="longfichfilm.php?ID='.$filmid.'"> Fiche Détaillée </a></li>
							<li><a href="casting.php?ID='.$filmid.'"> Casting </a></li>';
							// actions conditionnées
							if(!is_null($filmStatus['echanger']))
								{ // verifier Dispo
								if($filmdispo['PasRendu']==0)
									{echo'<li><a href="addtocart.php?action=emprunt&IDfilm='.$filmid.'"> Emprunter </a></li>';}
								else { echo '<li>En Prêt, pas disponible</li>';}
								}
							else { echo '<li>Pas en Prêt</li>';}	
							
							if($filmStatus['echanger']==1)
								{echo '<li><a href="addtocart.php?action=echange&IDfilm='.$filmid.'"> Echanger </a></li>';}
							else 
								{echo '<li> Non échangeable</li>';}
							if(!is_null($filmStatus['vendre']))
								{echo '<li><a href="addtocart.php?action=vente&IDfilm='.$filmid.'"> Acheter pour '.$filmStatus['vendre'].' Euros </a></li>	';}
							else 
								{echo '<li> Pas à Vendre </li>';}
							// pour ajouter une option, c'est ICI !
							echo '</ul>';
							echo "</nav></div>";
						
					}
					else
					{
						echo 'aucun résultat, <a href="fichefilm.php" > Choisissez </a> un nouveau numéro de film ...';
					}
		$connexion->close();
			}
			// fin du traitement de la page appelée avec paramètre
	}
?>
    </div><!-- end .content -->
  <div class="footer">
    <?php require "includes/footer.ssi"; ?>    
  </div>
  <!-- end .container --></div>
</body>
</html>