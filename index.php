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
  <H1> Bienvenue sur notre site de partage de Films sur BluRay </H1>
  <H2> Présentation</H2>
  <p align="justify">Ce site est créé pour et par une communauté de passionés de disques BluRay.
  Il recense tous les disques BluRay possédés par nos membres, et permet de connaître pour chacun de ces films de nombreuses informations, généralement extraites de bases de données publiques (OMDB, IMDB ... ) ou complétées par nos membres.
  </p>  
  <H2> Règles de fonctionnement</H2>
  <p align="justify">La consultation des fiches de tous les films du club, le visionnage des bandes annonces et les filmogaphies des acteurs sont ouvertes à tous publics. Les BluRay présents dans nore base appartiennent à nos membres, qui peuvent les emprunter, les échanger ou les vendre à travers le site.
  <p align="justify"><Pour devenir membre, il faut s'engager à ajouter des BluRays à notre catalogue et de les mettre à disposition des autres membres. L'inscription est libre et gratuite. Les membres qui ne proposent pas de disques peuvent être bannis du site.</p>
  <p align="justify">
  L'inscription permet d'accéder à la partie "membre" du site et d'accéder aux fonctionnalités de prêt, d'échange ou de revente de films sur disques BluRay.
  </p>  
  <H2> Réalisation</H2>
  <p align="justify">La réalisation de ce site est un projet pédagogique de BTS SIO, dont l'objectif est de permettre aux étudiants d'acquérir progressivement les compétences nécessaires à sa conception et à sa réalisation. C'est un projet "fil rouge" du module SI6 "création d'applications" réalisé par phases successives.</p>
  <p align="justify">
Chaque phase est l'occasion d'introduire de nouvelles technologies( HTML5, CSS3, PHP, Javascript ) et des techniques particulières ( formulaires, Variables Serveur, gestion des sessions .....)</p>
  <p align="justify">
Chaque phase se construit sur la correction fournie par le professeur des phases précédentes consolidées, ce qui permet à tous les étudiants, quelles qu'aient été leurs difficultés pendant certaines étapes, de repartir sur des bases saines et de terminer avec un projet complet, fonctionnel et documenté, qui pourra leur servir d'inspiration pour réaliser d'autres site dynamiques.  
  </p>  
  </div><!-- end .content -->
  <div class="footer">
    <?php require "includes/footer.ssi"; ?>    
  </div>
  <!-- end .container --></div>
</body>
</html>