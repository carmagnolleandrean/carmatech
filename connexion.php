<!DOCTYPE html>
<html lang="fr">
    <?php require 'connexionAction.php'; ?>
    
<head>
  <link rel="stylesheet" href="../styleconnexion.css"/>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Connexion</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
</head>
<body>
  <form method="POST"> 
     
    <h1>Se connecter</h1> 
    <div class="inputs">
      <input type="text" placeholder="Mail" name="mail" >
      <input type="password" placeholder="Mot de passe" name="motdepasse" >
    </div>

    <?php if(!empty($erreurMsg)) { echo '<p class="error">' . $erreurMsg . '</p>'; } ?>
    
    <p class="inscription">Je n'ai pas de <span>compte</span>. Je m'en <span><a id="lieninscription" href="inscription.php">crée un.</a></span></p>

    <div>
      <button type="submit" name="boutonConnexion">Se connecter</button>
    </div>
  </form>
</body>
</html>
