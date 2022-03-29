<?php
// script qui gère l'autentification sur l'espace membre (dans le header de toutes les pages)
session_start();
echo '<img src="images/Blu-ray_Disc.png" width="200">'; // logo bluray
// y a-t-il un membre connecté ?
if(isset($_SESSION['Authenticated']))
{
	// message de bienvenue et lien de logout
	echo '<div class="loginbox"';
	echo '<p align"right">';
	echo '<H2 class="loginbox">Bienvenue, '.$_SESSION['Authenticated']['login'].'</H2>';
	echo 'Vous êtes connecté en mode <strong>'.$_SESSION['Authenticated']['mode'].'</strong>';
	echo '<br>Cliquez sur ce lien pour <a href="logout.php"> Vous Déconnecter </a>';
	echo "</p>";
	echo "</div>";	
}
else {
		// la page est-elle appelée par le formulaire de login, avec login et password non vides ?
		if(isset($_POST) && !empty($_POST['identifiant'])&&!empty($_POST['mot_de_passe']))
			{
			extract($_POST);
			$lepasse = $_POST['mot_de_passe'];
			// les identifiants sont-ils corrects ?			
			// on requête pour authentifier par comparaison
			require_once "includes/connectbdd.php";
			$requete= 'SELECT * FROM t_membres WHERE pseudo ="'.$_POST['identifiant'].'"';
			$result=$connexion->query($requete) or die('Echec de la requête');
			if($result->num_rows>0)
			{
				$fiche = $result->fetch_assoc();
				$monID = $fiche['IDuser'];
				// vérification du mot de passe
				if(password_verify($lepasse,$fiche['password']))
				{	// création de variables de session
					if($fiche['IsAdmin']==1){
						$mode="administrateur";
						}
						else {
						$mode= "membre";
						}
					$_SESSION['Authenticated']= array(
								'monID'=>$monID,
								'login'=>$identifiant,
								'pass'=>$lepasse,
								'mode'=>$mode );
					// recharger la page qui contient cet en-tête pour en actualiser le cartouche
					header("location:".$_SERVER['SCRIPT_NAME']."");
				}
				else
				{ // la vérification du mot de passe a échoué
					echo ' Identifiant et/ou Mot de Passe Incorrects ou Invalides
					<a href="'.$_SERVER['SCRIPT_NAME'].'"> Réessayer </a>';
				}
			}
			else 
			{	// la requête sur base de donnée ne retourne pas de couple PSEUDO:Password 
				echo 'Identification impossible dans la base de données <a href="'.$_SERVER['SCRIPT_NAME'].'"> Réessayer </a>';	
			}
		}
		else
		{	// afficher le formulaire de connexion et l'invitation à s'inscrire
			echo '
			<DIV class="loginbox">
				<FORM action="'.$_SERVER['SCRIPT_NAME'].'" method="POST" id="loginform">
					<TABLE class="blueTable">
					<tr>
						<th colspan="2" align="center"> Connexion Membre </th>
					</tr>
					<tr>
						<td><label for "UserId" > Votre Identifiant: </label></td>
						<td><input type="text" name="identifiant" id="UserId" size ="12" maxlength="12"></td>
					</tr>
					<tr>
						<td><label for "pswd" > Votre Mot de Passe: </label></td>
						<td><input type="password" name="mot_de_passe" id="pswd" size = "12" maxlength="12"></td>
					</tr>
					<tr>
						<td colspan="2"align="center"><input type="submit" value=".    Connecte Moi    ."</td>
					</tr>
					</TABLE>
				</FORM>
			</DIV>';
			echo '<br>Pour accéder à toutes les fonctionnalités du site, 
			<br>vous devez <a href="inscription.php"> vous inscrire (c\'est GRATUIT!)</a>';
		} // fin du formulaire
} // fin du traitement en absence de création de session
?>