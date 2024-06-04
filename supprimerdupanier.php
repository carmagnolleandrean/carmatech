<?php
require_once 'connexion/bdd.php';
require_once 'connexion/securiteAction.php';

if (isset($_POST['boutonSupprimer'])) {
    $idArticle = htmlspecialchars($_POST['idArticle']);
    $idClient = $_SESSION['id']; // ID de l'utilisateur connecté

    try {
        // supprimer l'article du panier
        $deleteFromPanier = $bdd->prepare('DELETE FROM Panier WHERE idArticle = ? AND idClient = ?');
        $deleteFromPanier->execute([$idArticle, $idClient]);

        // On se redirige vers la page du panier
        header('Location: panier.php');
        exit();
    } catch (PDOException $e) {
        $errorMsg = "Erreur lors de la connexion à la base de données : " . $e->getMessage();
    }
}
?>
