<?php
require_once 'connexion/bdd.php';
require_once 'connexion/securiteAction.php';

// vrifier si le formulaire a été soumis
if (isset($_POST['boutonPanier'])) {
    // récupérer les données du formulaire
    $idArticle = htmlspecialchars($_POST['idArticle']);
    $quantiteeArticle = htmlspecialchars($_POST['quantiteeArticle']);
    $idClient = $_SESSION['id']; // ID de l'utilisateur connecté

    try {
        // Vérifier le stock de l'article
        $verifStock  = $bdd->prepare('SELECT stockArticle FROM Article WHERE idArticle = ?');
        $verifStock ->execute([$idArticle]);
        $article = $verifStock->fetch();

        if ($article && $article['stockArticle'] >= $quantiteeArticle) {
            // Vérifier si l'article est déjà dans le panier
            $verifPanier = $bdd->prepare('SELECT quantiteeArticle FROM Panier WHERE idArticle = ? AND idClient = ?');
            $verifPanier->execute([$idArticle, $idClient]);

            if ($verifPanier->rowCount() > 0) {
                // Mise à jour de la quantité si l'article est déjà dans le panier
                $updatePanier = $bdd->prepare('UPDATE Panier SET quantiteeArticle = quantiteeArticle + ? WHERE idArticle = ? AND idClient = ?');
                $updatePanier->execute([$quantiteeArticle, $idArticle, $idClient]);
            } else {
                // Ajouter l'article dans le panier
                $ajouterAuPanier = $bdd->prepare('INSERT INTO Panier (idClient, idArticle, quantiteeArticle) VALUES (?, ?, ?)');
                $ajouterAuPanier->execute([$idClient, $idArticle, $quantiteeArticle]);
            }

            // Redirection vers la page du panier ou une confirmation
            header('Location: panier.php');
            exit();
        } else {
            $erreurMsg = "stock insuffisant pour cet article.";
        }
    } catch (PDOException $e) {
        $erreurMsg = "erreur lors de la connexion à la base de données : " . $e->getMessage();
    }
}
?>
