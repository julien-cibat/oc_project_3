<?php // Connexion Database    
try {
    $bdd = new PDO('mysql:host=localhost;dbname=project_3;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}

//======================================================================
// MATCHING DES INFORMATIONS (CONNEXION)
//======================================================================

// Vérification si username et password bien communiqués par utilisateur
if (!isset($_POST['username'])) {
    echo '<p>Pseudonyme manquant. Merci de fournir votre identifiant.</p>';
}
elseif (!isset($_POST['password'])) {
    echo '<p>Mot de passe manquant. Merci de fournir votre mot de passe.</p>';
}
else {
    // Récupération usersId et usersPassword en Base de données
    $req = $bdd->prepare('SELECT usersId, usersNom, usersPrenom, usersUsername, usersPassword FROM users WHERE usersUsername = :username');
    $req->execute(array(
        ':username' => $_POST['username']));

    $result = $req->fetch();

    $passworddb = $result['usersPassword'];

    // Matching password

    $isPasswordCorrect = password_verify($_POST['password'], $passworddb);

    if ($isPasswordCorrect) {
        session_start();
        $_SESSION['id'] = $result['usersId'];
        $_SESSION['nom'] = $result['usersNom'];
        $_SESSION['prenom'] = $result['usersPrenom'];
        $_SESSION['username'] = $result['usersUsername'];
        // Redirection page index
        header('Location: ../index.php');
    }
    else {
        echo '<p>Les mots de passe ne correspondent pas</p>';
        echo '<p>Si vous êtes bien titulaire de ce compte, merci de suivre la procédure de réinitialisation de mot de passe <a href="../recovery.php">Réinitialiser le mot de passe</a></p>';
        echo '<p>Revenir à la page précédente : <a href="../login.php">Connexion</a></p>';
    }

    // Libération du curseur pour prochaine requête
    $req->closeCursor();
}

