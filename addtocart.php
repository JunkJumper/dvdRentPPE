<?php
require "includes/entete.php"; //ajoute le menu d'authentification
require "includes/connectbdd.php";



function emprunt(int $idUser, String $idFilm) : void {
	empruntAvecDuree($idUser, $idFilm, 15);
}

function empruntAvecDuree(int $idUser, String $idFilm, int $dureeEmprunt) : void {
	require "includes/connectbdd.php";
	$dateNow = date("Y-m-d");
	$dateAfter = date("Y-m-d", strtotime("$dureeEmprunt Days"));
	$query = "INSERT INTO emprunter (IDemprunteur, IDfilm, date_pris, date_due) VALUES ($idUser, $idFilm, '$dateNow', '$dateAfter');";
	
	echo '<br />' .$query .'<br />';
	$result=$connexion->query($query) or die('Echec de la requête, <a href="index.php"> Refaire un essai </a>');
	$connexion->close();
	echo '<script>'
			.'setTimeout(function () {'
			.'window.location.href = "http://dvdrentppe.test/fichefilm.php?ID=' .$idFilm .'";'
			.'}, 0);'
		.'</script>';
}

function empruntNotConnected(String $idFilm) : void {
	echo '<script>'
			.'setTimeout(function () {'
			.'window.location.href = "http://dvdrentppe.test/fichefilm.php?ID=' .$idFilm .'&nc=true";'
			.'}, 0);'
		.'</script>';
}

if(isset($_SESSION['Authenticated'])) {
	
	$reqs=$_SERVER['QUERY_STRING'];  // on stocke le parametre dans une variable
	// verifier que le parametre est correct, protéger de l'injection SQL
	if (substr($reqs,0,6) !== "action")
		{
			echo '<H2>'.'   '.$reqs.'   '.' Parametres transmis Invalides !';	
		}
	else
		{
			$req = explode("&", $reqs)[1];

			if(explode("=", $req)[0] = "emprunt") {
				emprunt($_SESSION['Authenticated']['monID'], explode("=", $req)[1]);
			}
		}
} else {
	empruntNotConnected(explode("=", explode("&", $_SERVER['QUERY_STRING'])[1])[1]);
}

?>