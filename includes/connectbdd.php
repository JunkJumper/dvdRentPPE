<?php
// segment php pour connexion à la base de données
// doit être appelé par require_once à l'intérieur d'une balise script php

$DSN=array('hostname'=>"localhost", 'username'=>"btssio", 'password'=>"rynax2019", 'dbname'=>"bdrbase");
$connexion=mysqli_connect($DSN['hostname'], $DSN['username'], $DSN['password'], $DSN['dbname']);
$connexion->set_charset("utf8");