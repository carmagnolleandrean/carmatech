<?php
require_once '../connexion/bdd.php';

if (isset($_POST['boutonConnexion'])) {
    if (!empty($_POST['mail']) && !empty($_POST['motdepasse'])) {
        $utilisateur_mail = htmlspecialchars($_POST['mail']);
        $utilisateur_mdp = $_POST['motdepasse'];
        
        // Requête SQL pour récupérer l'utilisateur par email
        $utilisateurExistant = $bdd->prepare('SELECT * FROM client WHERE Mail = ?');
        $utilisateurExistant->execute(array($utilisateur_mail));
        
        // Vérifier que l'utilisateur existe
        if ($utilisateurExistant->rowCount() > 0) {
            $infosUtilisateur = $utilisateurExistant->fetch();
            $hash_mdp = $infosUtilisateur['mdp'];
           
            
            // Vérification du mot de passe
            if (password_verify($utilisateur_mdp, $hash_mdp)) {
                $_SESSION['auth'] = true;
                $_SESSION['id'] = $infosUtilisateur['idClient'];
                $_SESSION['nom'] = $infosUtilisateur['Nom'];
                $_SESSION['prenom'] = $infosUtilisateur['Prenom'];
                $_SESSION['mail'] = $infosUtilisateur['Mail'];
                
                // Rediriger vers la page d'accueil
                header('Location: ../index.php');
                exit;
                
            } else {
                $errorMsg = "Votre mot de passe est incorrect";
            }
        } else {
            $errorMsg = "Votre email est incorrect";
        }
    } else {
        $errorMsg = "Veuillez compléter tous les champs";
    }
}
?>
