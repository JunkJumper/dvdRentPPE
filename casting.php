<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Casting du Film</title>
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
			echo '<h2 class="danger"> il faut obligatoirement préciser un N° de film</h2>';
			echo '<a href="fichefilm.php"> retourner choisir un film</a>';
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
					require "includes/connectbdd.php";
					$query='SELECT Acteur, Personnages FROM jouerfilm WHERE jouerfilm.ID_film = '.$filmid.' ;' ;
					$result=$connexion->query($query) or die('Echec de la requête, <a href="casting.php"> Refaire un essai </a>');
						if ($result->num_rows > 0) 		// On verifie que le résultat de la requête n'est pas vide
						{
							echo "<H1>Casting du film N°".$filmid." :</H1>";
							echo '<table class="blueTable"><TR><TH>Acteur/Actrice</TH><TH>Personnages Joués</TH></TR>';
							while($fiche = $result->fetch_array())
								{	
								$acteur = str_replace(" ","%20",$fiche['Acteur']); //pour pouvoir passer le nom dans l'url						
								echo '<TR>
								<TD><a href="filmography.php?Acteur='.$acteur.'">'.$fiche['Acteur'].'</a></TD>
								<TD>'.$fiche['Personnages'].'</TD>
								</TR>';
								}
								echo "</table><BR>";
						}
						else
						{
							echo 'aucun résultat, <a href="casting.php" > Choisissez </a> un nouveau numéro de film ...';
						}
					$connexion->close();
				}
				// fin du traitement de la page appelée avec paramètre
		}
	}
	else
	{
		echo '<H2 class="danger"> Vous devez vous identifier pour visualiser les castings </H2>';
	}
?>
    <!-- end .content --></div>
  <div class="footer">
    <?php require "includes/footer.ssi"; ?>    
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
</html>