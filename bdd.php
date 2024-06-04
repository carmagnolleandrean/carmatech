<?php
try {
    session_start();
    $bdd = new PDO('mysql:host=localhost;dbname=ecommerce;charset=utf8;', 'root', '');
}catch(Exception $e){
    die('Une erreur est survenue :' . $e->getMessage());
}
