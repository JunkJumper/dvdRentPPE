<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Modification du profil membre</title>
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
	<H1> Modifier mon profil de Membre</H1>
	<section id="Registerform">
<?php
// y a-t-il une session ouverte, un login défini ?
if(isset($_SESSION['Authenticated']) && !empty($_SESSION['Authenticated']['login']))
	{ // y a-t-il des données de formulaire valides transmises à la page ?
	if(isset($_POST['MonID']) && isset($_POST['oldpswd']))
		{	// oui => mode traitement des données de formulaire
			// lecture des données AVANT modif
			require "includes/connectbdd.php";
			$sqlreq2 = 'SELECT * FROM t_membres WHERE IDuser ='.$_POST['MonID'];
			echo $sqlreq2;
			$result2=$connexion->query($sqlreq2) 
			or die('Echec de la requête, <a href="editprofil.php"> Refaire un essai </a>');
			if($result2->num_rows > 0)
				{
					$oldprofil=mysqli_fetch_assoc($result2);
				// vérification des données transmises
					echo '<TABLE class="blueTable">';
					foreach($_POST as $param => $valeur)
						{ 
						echo "<TR>";
						echo '<TD>'.$param. ' </TD><TD> ==></TD><TD>'.$valeur.'</TD>'; 
						echo "</TR>";
						}  
					echo '</table>';
				// vérification du mot de passe fourni 
				if(!password_verify($_POST['oldpswd'],$oldprofil['password']))
					
					{
						// echo 'mauvais pass, modif interdite';
						// echo '<a href="editprofil.php"> Refaire un essai </a>';
						header("location:".$_SERVER['SCRIPT_NAME']."");	
					}
				else					  					
					{ // fabrication de la requête mise à jour des champs modifiés
						$virgul = false; // pour ne pas avoir de virgule en trop dans la requête
						$sqlreq ='UPDATE t_membres SET ';
						// maj du pseudo
						if($_POST['pseudo']!= $oldprofil['pseudo'])
							{ $sqlreq = $sqlreq.'pseudo = "'.$_POST['pseudo'].'"';
							$virgul = true;
							}
						// maj du password si non vide et verif ok
						if($_POST['newpswd']==$_POST['pswdverif'] && !empty($_POST['pswdverif']))
							{ 
							if($virgul==true){$sqlreq = $sqlreq.', ';}
							$sqlreq = $sqlreq.'password = "'. password_hash($_POST['newpswd'],PASSWORD_BCRYPT).'"';
							$virgul = true;}
							}
						// maj du nom
						if($_POST['nom']!= $oldprofil['nom'])
							{ 
							if($virgul==true){$sqlreq = $sqlreq.', ';}
							$sqlreq = $sqlreq.' nom = "'.$_POST['nom'].'"';
							$virgul = true;
							}
						// maj du prénom
						if($_POST['prenom']!= $oldprofil['prenom'])
							{ 
							if($virgul==true){$sqlreq = $sqlreq.', ';}
							$sqlreq = $sqlreq.' prenom = "'.$_POST['prenom'].'"';
							$virgul = true;
							}
						// maj de la Date	
						if($_POST['depuis']!= $oldprofil['daterole'])
							{
							 if($virgul==true){$sqlreq = $sqlreq.', ';}
							 $sqlreq = $sqlreq.' daterole = "'.$_POST['depuis'].'" ';
							}				
						$sqlreq = $sqlreq.' WHERE IDuser = "'.$_POST['MonID'].'";';
						// exécution de la requête de mise à jour
						echo "La requête soumise est : ".$sqlreq."<br>";
						$maj=$connexion->query($sqlreq) or die('Echec de la mise à jour, 
						<a href="editprofil.php"> Refaire un essai </a>');
						// succès, réafficher le profil
						echo '<a href="editprofil.php"> Voir le profil mis à jour </a>';
						// header("location:".$_SERVER['SCRIPT_NAME']."");	
					}
				}
	else 
		{ // non => mode afficher le formulaire
			require "includes/connectbdd.php";
			$sqlreq3 = 'SELECT * FROM t_membres WHERE pseudo="'.$_SESSION['Authenticated']['login'].'"';
			$result3=$connexion->query($sqlreq3) or die('Echec de la recherche du profil, <a href="editprofil.php"> Refaire un essai </a>');
			if ($result3->num_rows > 0)
				{	// Préremplir les champs avec les données de la base ou de la session.
					$monprofil=mysqli_fetch_assoc($result3);
					echo '
					<FORM action="editprofil.php" method="post">
					<table class="blueTable" >
					<input type="hidden" value="'.$monprofil['IDuser'].'" name="MonID">
					<tr>
						<th colspan="2" align="center">	Profil Membre </th>
					</tr>
					<tr>
						<td><label for "pseudo"> Votre pseudo: </label></td>
						<td><input type="text" name="pseudo" id="UserId" 
						value ="'.$monprofil['pseudo'].'" size ="12" maxlength="12"> </td>
					</tr>
					<tr>
						<td><label for "oldpswd" > Votre Ancien Mot de Passe: </label></td>
						<td><input type="password" required name="oldpswd" id="oldpswd" size = "8" maxlength="8"> (* Obligatoire pour modifier)</td>
					</tr>
					<tr>
						<td><label for "pswd" > Votre Nouveau Mot de Passe: </label></td>
						<td><input type="password" name="newpswd" id="newpswd" size = "8" maxlength="8"></td>
					</tr>
					<tr>
						<td><label for "pswdverif" > Verification du Mot de Passe: </label></td>
						<td><input type="password" name="pswdverif" id="pswdverif" size = "8" maxlength="8"></td>
					</tr>
					<tr>
						<td><label for "UserId" > Votre nom: </label></td>
						<td><input type="text" name="nom" id="lenom" value ="'.$monprofil['nom'].'" size ="12" maxlength="12"></td>
					</tr>
					<tr>
						<td><label for "UserId" > Votre Prénom: </label></td>
						<td><input type="text" name="prenom" id="leprenom" value ="'.$monprofil['prenom'].'" size ="12" maxlength="12"></td>
					</tr>
					<tr>
						<td><label for "DateMembre" > Date: </label></td>
						<td><input type="date" name="depuis" id="DateMembre" value ="'.$monprofil['daterole'].'" size ="12" maxlength="12"></td>
					</tr>
					<tr>
						<td colspan="2"align="center"><input type="submit" value=" Enregistrer les Modifications"</td>
					</tr>
					</table>
					</FORM>
					';
				}
			else 
				{
					echo ' aucune info pour ce pseudo ';
				}
		}
	}
else
	{ // il n'y a pas de session valide
	echo '<H2 class="danger"> Vous devez vous identifier pour modifier votre profil </H2>';
	}

?>		
	</section>
	</div><!-- end .content -->
	<div class="footer">
    <?php require "includes/footer.ssi"; ?>    
	</div><!-- end .footer -->
</div><!-- end .container -->
</body>
</html>