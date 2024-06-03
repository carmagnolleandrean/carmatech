<?php
require_once '../connexion/bdd.php';

// Validation du Formulaire
if (isset($_POST['boutonInscription'])) {
    // Vérifier si l'utilisateur a bien complété tous les champs
    if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['mail']) && !empty($_POST['motdepasse'])) {
        
        // Les données de l'utilisateur
        $utilisateur_nom = htmlspecialchars($_POST['nom']);
        $utilisateur_prenom = htmlspecialchars($_POST['prenom']);
        $utilisateur_mail = htmlspecialchars($_POST['mail']);
        $utilisateur_mdp = password_hash($_POST['motdepasse'], PASSWORD_BCRYPT);
        

        try {
            // Vérifier si l'utilisateur existe déjà sur le site
            $utilisateurExistant = $bdd->prepare('SELECT Mail FROM client WHERE Mail = ?');
            $utilisateurExistant->execute([$utilisateur_mail]);
            
            if ($utilisateurExistant->rowCount() == 0) {
                // Insérer l'utilisateur dans la bdd
                $creerUtilisateur = $bdd->prepare('INSERT INTO client (Nom, Prenom, Mail, mdp) VALUES (?, ?, ?, ?)');
                $creerUtilisateur->execute([$utilisateur_nom, $utilisateur_prenom, $utilisateur_mail, $utilisateur_mdp]);
                
                // Récupérer les informations de l'utilisateur
                $obtenirinfoUtilisateur = $bdd->prepare('SELECT * FROM client WHERE Mail = ?');
                $obtenirinfoUtilisateur->execute([$utilisateur_mail]);
                $infosUtilisateur = $obtenirinfoUtilisateur->fetch();
                
                if ($infosUtilisateur) {
                    // Authentifier l'utilisateur sur le site et récupérer ses données dans des sessions
                    $_SESSION['auth'] = true;
                    $_SESSION['id'] = $infosUtilisateur['idClient'];
                    $_SESSION['nom'] = $infosUtilisateur['Nom'];
                    $_SESSION['prenom'] = $infosUtilisateur['Prenom'];
                    $_SESSION['mail'] = $infosUtilisateur['Mail'];
                    
                    // Redirige l'utilisateur vers la page de connexion
                    header('Location: connexion.php');
                    exit();
                } else {
                    $errorMsg = "Erreur lors de la récupération des informations utilisateur.";
                }
            } else {
                $errorMsg = "L'utilisateur existe déjà avec cet e-mail.";
            }
        } catch (PDOException $e) {
            $errorMsg = "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        }
    } else {
        $errorMsg = "Veuillez compléter tous les champs.";
    }
}
?>
