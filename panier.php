<?php
require_once 'connexion/bdd.php';
require_once 'connexion/securiteAction.php';

// Récupérer l'ID du client connecté
$idClient = $_SESSION['id'];

// Récupérer les articles du panier pour l'utilisateur connecté
$query = $bdd->prepare('
    SELECT a.nomArticle, a.prixArticle, a.stockArticle, p.quantiteeArticle, a.idArticle, ph.nomPhoto
    FROM Panier p
    INNER JOIN Article a ON p.idArticle = a.idArticle
    INNER JOIN Photo ph ON a.idArticle = ph.idArticle
    WHERE p.idClient = ?
');
$query->execute([$idClient]);
$panier = $query;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon panier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Barre de navigation -->
    <nav>
        <ul>
            <li><a href="index.php">La boutique</a></li>
            <li><a href="#">Mes commandes</a></li>
            <li><a href="panier.php">Mon panier</a></li>
            <li><a href="#">Mes informations</a></li>
            <li><a href="connexion/deconnexionAction.php">Déconnexion</a></li>
        </ul>
    </nav>
    
    <!-- Conteneur du titre -->
    <header>
        <h1>Mon panier</h1>
    </header>
        
    <!-- Section principale -->
    <main>

        <!-- Section des articles -->
        <section>
            <?php
            if ($panier->rowCount() > 0) {
                // Sortir les données de chaque ligne
                while ($row = $panier->fetch()) {
                    echo "<div class='article'>";
                    echo "<h3>" . htmlspecialchars($row['nomArticle']) . "</h3>";
                    echo "<img src='images/" . htmlspecialchars($row['nomPhoto']) . "' alt='" . htmlspecialchars($row['nomArticle']) . "'>";
                    echo "<p>Prix : " . htmlspecialchars($row['prixArticle']) . "€</p>";
                    echo "<p>Quantité : " . htmlspecialchars($row['quantiteeArticle']) . "</p>";
                    echo "<form method='post' action='supprimerdupanier.php'>";
                    echo "<input type='hidden' name='idArticle' value='" . htmlspecialchars($row['idArticle']) . "'>";
                    echo "<button type='submit' name='boutonSupprimer'>Supprimer du panier</button>";
                    echo "</form>";
                    echo "<form method='post' action='acheterarticle.php'>";
                    echo "<input type='hidden' name='idArticle' value='" . htmlspecialchars($row['idArticle']) . "'>";
                    echo "<input type='hidden' name='quantiteeArticle' value='" . htmlspecialchars($row['quantiteeArticle']) . "'>";
                    echo "<button type='submit' name='boutonAcheter'>Acheter</button>";
                    echo "</form>";
                    echo "</div>";
                }
            } else {
                echo "<p>Votre panier est vide.</p>";
            }
            ?>
        </section>
    </main>

    <!-- Pied de page -->
    <footer>
        <p>Mentions légales</p>
    </footer>
</body>
</html>
