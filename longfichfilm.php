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
				$query="SELECT * 
				FROM t_films LEFT JOIN resumerfilm ON (t_films.ID_film = resumerfilm.﻿ID_film)
				WHERE t_films.ID_film=".$filmid;

				$reqElTab = "SELECT URI_Affiche, URI_JaquetteAR, URI_JaquetteAV, Miniature, `Arrière-plan`, URL_BA
				FROM t_films LEFT JOIN resumerfilm ON (t_films.ID_film = resumerfilm.﻿ID_film)
				WHERE t_films.ID_film=$filmid";
				// echo $query;
				$result=$connexion->query($query) or die('Echec de la requête, <a href="longfichfilm.php"> Refaire un essai </a>');
				$elTab=$connexion->query($reqElTab)->fetch_assoc() or die('Echec de la requête des imgs');
					if ($result->num_rows > 0)
					{
						if(isset($_GET['nc'])) {
							if($_GET['nc'] == true) {
								echo '<h2 class="danger">Vous devez être connecté·e pour emprunter ce film !</h2>';
							}
						}
				
						$longfich = $result->fetch_assoc();
						$fiche = $result->fetch_array();

						
				
						echo '<table class="blueTable">'
									.'<tr>'
										.'<th>Attribut</th>'
										.'<th>Valeur</th>'
									.'</tr>';

						foreach($longfich as $key => $val) {
							if(isset($val)) {
								echo '<tr>'
									.'<td>' . str_replace("_", " ", str_replace("-", " ", $key)) .'</td>'
									.'<td>' .$val .'</td>'
								.'</tr>';
							}
						}
						echo '</table>';


							
							// affichage des actions possibles (emprunter/acheter/échanger) pour ce BluRay
							echo '<div><nav>';

							echo '<table class="blueTable">'
									.'<tr>'
										.'<th>Attribut</th>'
										.'<th>Valeur</th>'
									.'</tr>';

						foreach($elTab as $key => $val) {
							if(isset($val)) {
								if(strtoupper(substr($val, 0, 1)) == "I") {
									echo '<tr>'
										.'<td>' . str_replace("_", " ", str_replace("-", " ", $key)) .'</td>'
										.'<td><img src="' . str_replace("\\", "/", $val) .'" /></td>'
									.'</tr>';
								} else {
									echo '<tr>'
										.'<td>Bande annonce</td>'
										.'<td><iframe width="420" height="315"'
											.'src="' . str_replace("watch?v=", "/embed/", $val) .'"frameborder="0" allowfullscreen>'
											.'</iframe>'
										.'</td>'
									.'</tr>';
								}
							}
						}
						echo '</table>';
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