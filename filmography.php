<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Filmographie d'un Acteur</title>
<link href="css/bluraycss.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
  <div class="header">
  <?php require "includes/entete.php"; //ajoute le menu de navigation ?>   
  </div>
  <div class="sidebar1">
  <?php require "includes/sidebar1.ssi"; //ajoute le menu de navigation ?>   
  </div> <!-- end .sidebar1 -->
  <div class="content">
<?php
// y a-t-il une session ouverte, un login défini ?
if((isset($_SESSION['Authenticated'])) && (!empty($_SESSION['Authenticated']['login'])))
	{
	// On vérifie si la page a été appelée sans Paramètre
	if ($_SERVER['QUERY_STRING']=='')
		{ // afficher message d'erreur et lien de retour vers page appelante
			echo '<h2 class="danger"> il faut obligatoirement préciser un Nom d\'Acteur</h2>';
			echo '<a href="fichefilm.php"> retourner choisir un film</a>';
		}
	else		
		{
			$acteur=$_GET['Acteur'];  // on stocke le parametre dans une variable							
			echo "<H1>filmographie de $acteur </H1>";
			require "includes/connectbdd.php";
					
			$query2='SELECT imDBid FROM t_acteurs WHERE acteur="'.$acteur.'";';
			$result2=$connexion->query($query2) or die('Echec de la requête, <a href="casting.php"> Refaire un essai </a>');
			$profil=$result2->fetch_array();
			$profilid=$profil[0];
			
			$query='SELECT t_films.ID_film, t_films.Titre,jouerfilm.Personnages
					FROM jouerfilm INNER JOIN t_films ON jouerfilm.ID_film = t_films.ID_film
					WHERE jouerfilm.Acteur = "'.$acteur.'";';
					$result=$connexion->query($query) or die('Echec de la requête, <a href="casting.php"> Refaire un essai </a>');
			
						if ($result->num_rows > 0) 		// On verifie que le résultat de la requête n'est pas vide
						{
							echo '<table class="blueTable"><TR><TH>N° Film</TH><TH>Titre</TH><TH>Rôles</TH></TR>';
							while($fiche = $result->fetch_array())
								{					
								echo '<TR>
									<TD><a href="fichefilm.php?ID='.$fiche['ID_film'].'" >'.$fiche['ID_film'].'</a></TD>
									<TD>'.$fiche['Titre'].'</TD>
									<TD>'.$fiche['Personnages'].'</TD>
									</TR>';
								}
								echo "</table><BR>";
								//echo $profilid;
								if(!empty($profilid))
									{
										echo '<h3> <a href="https://www.imdb.com/name'.$profilid.'" target="_blank"> Voir son profil sur ImDB </a></h3>';
									}
						}
						else
						{
							echo 'aucun résultat, <a href="casting.php" > Choisissez </a> un nouveau numéro de film ...';
						}
					$connexion->close();
			
				// fin du traitement de la page appelée avec paramètre
		}
	}
	else
	{
		echo '<H2 class="danger"> Vous devez vous identifier pour visualiser les filmographies </H2>';
	}
?>
    <!-- end .content --></div>
  <div class="footer">
    <?php require "includes/footer.ssi"; ?>    
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
</html>