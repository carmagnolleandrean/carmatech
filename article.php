<?php

require_once 'connexion/bdd.php';

// Requête pour récupérer les articles et leurs photos
$articles = $bdd->prepare('SELECT * 
                           FROM Article 
                           INNER JOIN Photo ON Article.idArticle = Photo.idArticle');
$articles->execute();
?>

