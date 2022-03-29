<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Accueil Club BluRay</title>
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
  <H1> Devenir Membre du  Club BluRay </H1>
<section id="Registerform">
	<?php
    if((isset($_SESSION['Authenticated']))&& ($_SESSION['Authenticated']['mode']!="administrateur"))
	{
		// membre connecté inscription impossible
		echo '<H2 class="danger"> Vous ne pouvez pas créer de nouveau membre </h2>';
        echo 'Un membre connecté ne peut pas créer un autre membre<br>';
        echo 'Connectez-vous en administrateur pour créer un nouveau membre<br>';
        echo '<a href="logout.php"> J\'ai compris </a> ';
    }
    else 
	{ // afficher ou traiter le formulaire
		$erreurs=array();
		if(!empty($_POST))
			{ 	
			// traiter les données de formulaire reçues
			// pseudo obligatoire et non existant
			if(empty($_POST['identifiant'])){$erreurs['Pseudo_Manquant']="Un pseudo est obligatoire pour s'inscrire";}
			require "includes/connectbdd.php";
			$requete = 'SELECT * FROM t_membres WHERE pseudo = "'.$_POST['identifiant'].'" ;';
			// echo $requete;
			$result=$connexion->query($requete) or die('Echec de la requête recherche du pseudo');
			if($result->num_rows>0){$erreurs['PseudoExiste']="Ce pseudo existe déjà";}
			if(empty($_POST['newpass'])){$erreurs['NoPass']="Il est obligatoire de choisir un mot de passe";}
			if($_POST['newpass']!=$_POST['verifpass']){$erreurs['NotEqualPass']="Les mots de passe ne corresppondent pas";}
			if(empty($erreurs))
				{
					// pas d'erreur, donc on insère le nouveau membre
					$now = date("Y-m-d");
					$secret = password_hash($_POST['newpass'],PASSWORD_BCRYPT);
					$sqlinsreq = " INSERT INTO t_membres 
					(`IDuser`, `pseudo`, `password`, `nom`, `prenom`, `daterole`, `IsAdmin`) VALUES 
					( NULL, '".$_POST['identifiant']."' , '".$secret."', '".$_POST['nom']."' , '". $_POST['prenom']."' , '".$now."', '0' );";
					$result=$connexion->query($sqlinsreq) or die('Echec de la requête AJOUT nouveau membre');
					// Réussite
					echo "<H2> Creation du compte ".$_POST['identifiant']." Réussie </H2>";
					echo '<A href = "editprofil.php" > Voir ou Modifier votre Profil </A>(connexion nécessaire)';
				}
			else
				{  // afficher les erreurs et un lien pour recommencer
					echo '<H2 class="danger"> Saisie incorrecte </h2>';
					echo'<pre>';
					print_r($erreurs);
					echo '</pre>';			
					echo '<a href="inscription.php"> Recommencer </a>';
				}
			}
		else
			{ //Pas de données reçues dans $_POST, afficher le formulaire vierge
			echo '<FORM action="inscription.php" method="post">
				<table class="blueTable">
				<tr>
					<th colspan="2" align="center">	Création d\'un nouveau Membre </th>
				</tr>
				<tr>
					<td><label for "UserId" > Choisissez un Pseudo: </label></td>
					<td><input type="text" required name="identifiant" id="UserId" size ="12" maxlength="12"> </td>
				</tr>
				<tr>
					<td><label for "pswd" > Votre Mot de Passe: </label></td>
					<td><input type="password" name="newpass" id="pswd" size = "28" ></td>
				</tr>
					<tr>
					<td><label for "pswdverif" > Verification Mot de Passe: </label></td>
					<td><input type="password" name="verifpass" id="pswdverif" size = "28" </td>
				</tr>
				<tr>
					<td><label for "UserId" > Votre nom: </label></td>
					<td><input type="text" name="nom" id="UserId" size ="12" maxlength="28"></td>
				</tr>
				<tr>
					<td><label for "UserId" > Votre Prénom: </label></td>
					<td><input type="text" name="prenom" id="UserId" size ="12" maxlength="28"></td>
				</tr>
				<tr>
				<tr>
					<td colspan="2"align="center"><input type="submit" value=" Oui, Je veux m\'inscrire"</td>
				</tr>
				</table>
				</FORM>';
		}
	}
    ?>
    </section>
  </div><!-- end .content -->
  <div class="footer">
    <?php require "includes/footer.ssi" ?>    
  </div>
 </div> <!-- end .container -->
</body>
</html>