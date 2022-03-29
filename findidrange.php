<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sélection de Films</title>
<link href="css/bluraycss.css" rel="stylesheet" type="text/css">
</head>

<body>
<!- Version améliorée de Exo4.php : un second formulaire permet d'entrer des critères de sélection le résultat est multilignes ->
<div class="container">
  <div class="header">  	
  	<?php require "includes/entete.php"; //ajoute le menu d'authentification ?> 
  </div> <!-- end of header -->
  <div class="sidebar1">
  <?php require "includes/sidebar1.ssi"; ?>   
  </div>
  <div class="content">
    
<?php
// On vérifie si la page a été appelée sans Paramètre
if ($_SERVER['QUERY_STRING']=='')
	{ // il faut afficher le formulaire pour obtenir l'ID du film ou des critères de sélection
	echo '<form action="findidrange.php" method="get">';
	echo '<label>Saisissez le Numéro de film minimum ci-après ...</label>';
	echo '<input name="ID" type="text" value="" size="6" maxlength="5"><br>';
	echo '<label>Saisissez le Numéro de film maximum ci-après ...</label>';
	echo '<input name="ID2" type="text" value="" size="6" maxlength="5"><br>';
	echo '<label>Saisissez le nombre de films maximum à afficher ...</label>';
	echo '<input name="limit" type="text" value="10" size="3" maxlength="3"><br>';
	echo '<input name="valider" type="submit" value="Voir les fiches de ces film">';
	echo '</form>';
		//  le formulaire rappelle la page en lui envoyant les parametres ID et Valider
	}
else		
	{
		$filmid1=$_SERVER['QUERY_STRING'];  // on stocke le parametre dans une variable
		// verifier que le parametre est correct, protéger de l'injection SQL
		if (substr($filmid1,0,3) !== "ID=")
			{
				echo '<H2>'.'   '.$filmid1.'   '.' Parametres transmis Invalides !';	
			}
		else
			{
				// on traite la page avec un numéro de film valide.
				$filmid1 = $_GET['ID'];
				$filmid2 = $_GET['ID2'];
				$limlist = $_GET['limit'];  
				// echo $filmid1;
				require "includes/connectbdd.php";
				$query="SELECT ID_film, Titre, Réalisateur, Année, Miniature FROM t_films WHERE ID_film >=".$filmid1." AND ID_film <= ".$filmid2." limit " .$limlist.";";
				// echo $query;
				$result=$connexion->query($query) or die('Echec de la requête, <a href="findidrange.php"> Refaire un essai </a>');
		
					if ($result->num_rows > 0)
					{
						echo "<H1>Liste des ".$result->num_rows." films trouvés entre ".$filmid1." et ".$filmid2." .</H1>";
						echo '<table class="blueTable"><TR><TH>ID</TH><TH>Titre</TH><TH>Réalisateur</TH><TH>Année</TH><TH>Miniature</TH></TR>';
						while ($fiche = $result->fetch_array())
							{
							// préparation pour insertion de la miniature
							$urlmini = str_replace('\\', '/', $fiche['Miniature']);
							echo '<TR><TD><a href=fichefilm.php?ID='.$fiche['ID_film'].'> '.$fiche['ID_film'].'</TD>
							<TD>'.$fiche['Titre'].'</TD>
							<TD>'.$fiche['Réalisateur'].'</TD>
							<TD>'.$fiche['Année'].'</TD>
							<TD><img src="'.$urlmini.'" height="80px"></TD></TR>';
							}
							echo "</table><BR>";
					}
					else
					{
						echo 'aucun résultat, <a href="exo4b.php" > Choisissez </a> un nouveau numéro de film ...';
					}
		$connexion->close();
			}
			// fin du traitement de la page appelée avec paramètre
	}
?>
    <!-- end .content --></div>
    <div class="footer">
    <?php require "includes/footer.ssi"; ?>  
    </div>
  <!-- end .container --></div>
</body>
</html>