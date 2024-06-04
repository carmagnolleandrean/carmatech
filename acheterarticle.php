<?php
require_once 'connexion/bdd.php';
require_once 'connexion/securiteAction.php';

// Vérifier si le formulaire d'achat a été soumis
if (isset($_POST['boutonAcheter'])) {
    // recupérer les données du formulaire
    $idArticle = htmlspecialchars($_POST['idArticle']);
    $quantiteeArticle = htmlspecialchars($_POST['quantiteeArticle']);
    $idClient = $_SESSION['id']; // ID de l'utilisateur connecté

    try {
        // verifier le stock de l'article
        $verifStock = $bdd->prepare('SELECT stockArticle FROM Article WHERE idArticle = ?');
        $verifStock->execute([$idArticle]);
        $article = $verifStock->fetch();

        if ($article && $article['stockArticle'] >= $quantiteeArticle) {
            // mettre a jour le stock d'un article
            $updateStock = $bdd->prepare('UPDATE Article SET stockArticle = stockArticle - ? WHERE idArticle = ?');
            $updateStock->execute([$quantiteeArticle, $idArticle]);

            // ajouter la commande dans la base de données 
            $ajouterCommande = $bdd->prepare('INSERT INTO Commande (dateCommande, statusCommande, idClient) VALUES (NOW(), "Payée", ?)');
            $ajouterCommande->execute([$idClient]);

            // recupérer l'ID de la commande nouvellement créée
            $idCommande = $bdd->lastInsertId();

            // ajouter une ligne de commande
            $ajouterLigneCommande = $bdd->prepare('INSERT INTO ligneCommande (idArticle, quantiteeArticle, idCommande) VALUES (?, ?, ?)');
            $ajouterLigneCommande->execute([$idArticle, $quantiteeArticle, $idCommande]);

            // Supprimer l'article du panier
            $supprimerDuPanier = $bdd->prepare('DELETE FROM Panier WHERE idArticle = ? AND idClient = ?');
            $supprimerDuPanier->execute([$idArticle, $idClient]);

            // redirection vers une page de confirmation ou le panier
            header('Location: panier.php');
            exit();
        } else {
            $errorMsg = "Stock insuffisant pour cet article.";
        }
    } catch (PDOException $e) {
        $errorMsg = "Erreur lors de la connexion à la base de données : " . $e->getMessage();
    }
}
?>
