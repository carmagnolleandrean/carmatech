<!DOCTYPE html>
<html lang="fr">
    
    <!-- La ligne suivante est inutile car vous n'utilisez pas de PHP ici. 
    <?php require_once '../connexion/inscriptionAction.php'; ?> 
    -->
<head>
  
  <link rel="stylesheet" href="../styleconnexion.css"/>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inscription</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
</head>
<body>
    <form method="POST">    
    <h1>Inscription</h1> 
    
    <div class="inputs">
      <input type="text" placeholder="Nom" name="nom" >
      <input type="text" placeholder="Prénom" name="prenom" >
      <input type="text" placeholder="Mail" name="mail" >
      <input type="password" placeholder="Mot de passe" name="motdepasse" >
    </div>
    <?php if(!empty($erreurMsg)) { echo '<p class="error">' . $erreurMsg . '</p>'; } ?>
    <p class="inscription">J'ai déjà un <span>compte</span>. Je me <span><a id="lieninscription" href="connexion.php">connecte.</a></span></p>

    <div>
      <button type="submit" name="boutonInscription">S'inscrire</button>
    </div>
  </form>
</body>
</html>
