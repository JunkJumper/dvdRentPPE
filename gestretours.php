     <!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>BluRayClub Gestion des Retours</title>
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
   <h1>Gestion des Retours de Prêts </h1>
	<?php
	if(isset($_SESSION['Authenticated']) && $_SESSION['Authenticated']['mode']=="administrateur" )
		{ // l'utilisateur connecté a les privilèges "Administrateur"
			require "includes/connectbdd.php";			
			$today=date("Y-m-d");
			// prise en compte du filtrage éventuel sur liste
			if(!empty($_POST['Pseudo']))	
				{	$pseudo=$_POST['Pseudo'];
					$filtreSQL='AND t_membres.pseudo = "'.$pseudo.'" ';
				}
			else
				{	if(!empty($_GET['Pseudo']))	// si pas dans le post verifier dans le GET
					{
						$pseudo=$_GET['Pseudo'];
						$filtreSQL='AND t_membres.pseudo = "'.$pseudo.'" ';
					}
					else
					{	
						$pseudo="";
						$filtreSQL = "";
					}
				}
			if(!empty($_GET['IDuser']) && !empty($_GET['IDfilm']) &&!empty($_GET['date_pris']))
				{	// appel avec paramètres dans le $_GET, donc depuis un lien de mise à jour
					$query="UPDATE emprunter SET date_rendu = '".$today."'
					WHERE IDemprunteur = '".$_GET['IDuser']."' 
					AND IDfilm = '".$_GET['IDfilm']."'
					AND date_pris = '".$_GET['date_pris']."'
					;";
					// echo $query;
					$result=$connexion->query($query) or die("echec de la requête maj date retour");
					// rappeler la page sans paramètre pour que s'affiche la liste mise à jour
					header("location:gestretours.php?Pseudo=$pseudo");
				}
			else 
				{	// appel sans paramètre ou avec filtre via le POST
						// formulaire de filtrage
						echo '<FORM action="gestretours.php" method="POST" >'
							.'<label for="pseudo"> Filtrage par pseudo : </label>'
							.'<select name="Pseudo">';
						// récupérer la liste des emprunteurs actifs
						$sqlPseudos = 'SELECT DISTINCT pseudo FROM emprunter INNER JOIN t_membres ON						
						emprunter.IDemprunteur=t_membres.IDuser
						WHERE date_rendu IS NULL;';
						$pseudores=$connexion->query($sqlPseudos) or die("Pas possible de récupérer la liste de pseudos");
						// charger la liste des 
						if ($pseudores->num_rows >0)
							{
								while ($lepseudo = mysqli_fetch_array($pseudores)) 
								{
									echo '<option value="'.$lepseudo["pseudo"].'"> '.$lepseudo["pseudo"].'</option>';
								}
							}
						
						// ajouter le mode sans filtre par défaut("TOUS")
						echo '
						<option value="" selected> TOUS</option>';
						echo'
						</select>
						<input type="submit" value="filtrer">
						</FORM>';

					$query='SELECT emprunter.*, t_membres.pseudo, DATEDIFF(DATE(NOW()),emprunter.date_due)AS RETARD 
					FROM emprunter INNER JOIN t_membres ON IDemprunteur=IDuser
					WHERE date_rendu IS NULL '.
					$filtreSQL
					.' ORDER BY date_due ASC;';
					$result=$connexion->query($query) or die("échec de la requête liste des prês en cours");
					// affichage de la liste des prêts en cours
					echo '<table class="blueTable" style="text-align:center">';
					echo "<TR><th>Membre</th><th>Film</th><th>Pris le </th>
					<th>Attendu le</th><th>? Retard ?</th><th>Retours du ".$today." </th>";
					while ($data = mysqli_fetch_array($result)) 
						{
						// on affiche les résultats
						echo '<tr><td>'.$data['pseudo'].'</td>';
						echo '<td>'.$data['IDfilm'].'</td><td>'.$data['date_pris'].'</td>';
						echo "<td>".$data['date_due']."</td>";
						echo "<td>".$data['RETARD']."</td>";
						echo '<td><a href="gestretours.php?
						IDuser='.$data['IDemprunteur'].'
						&IDfilm='.$data['IDfilm'].'
						&date_pris='.$data['date_pris'].'
						&Pseudo='.$pseudo.'"> Valider Rendu </a>
						</td></tr>';
						}
					echo "</table>";
				}
			$connexion->close();
		}
		else // il n'a pas les privilèges admin
		{
			echo '<H2 class="danger"> Opération Interdite !</h2>';
			echo "Vous devez être administrateur pour pouvoir gérer les retours";
		}

	?>
  </div>  <!-- end .content -->
  <div class="footer">
    <?php require "includes/footer.ssi"; ?>  
   </div>
</div>  <!-- end .container -->
</body>
</html>