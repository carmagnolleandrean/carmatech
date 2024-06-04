<?php
require_once 'article.php';
require 'connexion/securiteAction.php'
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La boutique</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


    <!-- la barre de navigation -->
    <nav>
        <ul>
         <li><a href="index.php">La boutique</a></li>
          <li><a href="#">Mes commandes</a></li>
         <li><a href="panier.php">Mon panier</a></li>
         <li><a href="#">Mes informations</a></li>
         <li><a href="connexion/deconnexionAction.php">Déconnexion</a></li>
        </ul>
    </nav>
    
        <!-- le titre -->
    <header>
     <h1>La boutique</h1>
    </header>
        
    <!-- le main contenant le trie et les articles -->
    <main>
        <!-- section de triage des articles -->
<div id="triearticle">
            <h3>Trier par :</h3>
            <ul>
                <li><a href="#">Sortie récente</a></li>
                <li><a href="#">Popularité</a></li>
                <li>Catégorie</li>
                <ul>
                    <li><a href="#">Laptop</a></li>
                    <li><a href="#">Composant</a></li>
                    <li><a href="#">PC Fixe</a></li>
                </ul>
            </ul>
        </div>
        
        <div class="articles-title">
            <h2>Les articles</h2>
        </div>

        <!-- section des articles -->
<section>
    <?php
    if ($articles->rowCount() > 0) {
        // si le nombre de ligne récupérée est supérieur a 0 alors on les affiches avec leurs informations en bdd
        while ($row = $articles->fetch()) {
            echo "<div class='article'>";
            echo "<h3>" . htmlspecialchars($row['nomArticle']) . "</h3>";
            echo "<img src='images/" . htmlspecialchars($row['nomPhoto']) . "' alt='" . htmlspecialchars($row['nomArticle']) . "'>";
            echo "<p>note : " . htmlspecialchars($row['nombreNote']) . "</p>";
            echo "<p>prix : " . htmlspecialchars($row['prixArticle']) . "€</p>";
            echo "<p>stock article : " . htmlspecialchars($row['stockArticle']) . "</p>";
            
            echo "<form method='post' action='ajouterpanier.php'>";
            echo "<input type='hidden' name='idArticle' value='" . htmlspecialchars($row['idArticle']) . "'>";
            echo "<input type='number' name='quantiteeArticle' min='1' max='" . htmlspecialchars($row['stockArticle']) . "' value='1'>";
            echo "<button type='submit' name='boutonPanier'>Mettre dans le panier</button>";
            echo "</form>";
            
            echo "</div>";
        }
    } else {
        echo "0 résultats";
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
