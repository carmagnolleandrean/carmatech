<?php
// Vérifie si l'utilisateur est connecté, sinon redirige vers la page de connexion
if(!isset($_SESSION['auth'])){
    header('Location: connexion/connexion.php');
}
