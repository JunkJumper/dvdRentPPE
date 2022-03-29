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
		echo '<form action="findbyname.php" method="get">'
				.'<label>Saisissez le nom du film </label>'
				.'<input name="nomFilm" type="text" value="" size="" maxlength=""><br /><br />'
				.'<input name="valider" type="submit" value="Voir les fiches de ces film">'
			.'</form>';
		//  le formulaire rappelle la page en lui envoyant les parametres ID et Valider
	}
else		
	{

		$tabfilmName=$_SERVER['QUERY_STRING'];  // on stocke le parametre dans une variable
		// verifier que le parametre est correct, protéger de l'injection SQL

		if(substr($tabfilmName,0,7) !== "nomFilm") {
			echo '<H2>'.'   '.$tabfilmName.'   '.' Parametres transmis Invalides !';	
		} else {
			
		$filmName = strtoupper($_GET['nomFilm']);
		require "includes/connectbdd.php";
		$query="SELECT ID_film, Titre, Réalisateur, Année, Miniature FROM t_films WHERE UPPER(Titre) LIKE '%" .$filmName ."%';";
		//echo $query;
		$result=$connexion->query($query) or die('Echec de la requête, <a href="findbyname.php"> Refaire un essai </a>');

		if ($result->num_rows > 0)
		{
			echo "<H1>Liste des ".$result->num_rows." films trouvés.</H1>";
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
			echo 'aucun résultat, <a href="findbyname.php" > Choisissez </a> un autre nom de film ...';
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