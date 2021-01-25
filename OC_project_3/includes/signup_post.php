<?php // Connexion Database    
try {
    $bdd = new PDO('mysql:host=localhost;dbname=project_3;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}

//======================================================================
// VERIFICATION DES INFORMATIONS (INSCRIPTION)
//======================================================================

// Vérification formulaire complet
if (!empty($_POST['nom']) & !empty($_POST['prenom']) & !empty($_POST['username']) & !empty($_POST['password']) & !empty($_POST['question']) & !empty($_POST['reponse'])) 
{   
    //======================================================================
    // ENREGISTREMENT USERSINFO EN DATABASE
    //======================================================================

    // Hachage du mot de passe
    $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insertion en BDD
    $req = $bdd->prepare('INSERT INTO users(usersNom, usersPrenom, usersUsername, usersPassword, usersQuestion, usersReponse) VALUES(:nom, :prenom, :username, :userpassword, :userquestion, :userreponse)');
    $req->execute(array(
        ':nom' => $_POST['nom'],
        ':prenom' => $_POST['prenom'],
        ':username' => $_POST['username'],
        ':userpassword' => $pass_hash,
        ':userquestion' => $_POST['question'],
        ':userreponse' => $_POST['reponse']
        ));

    // Libération du curseur pour prochaine requête
    $req->closeCursor();

    // Redirection page index
    header('Location: ../login.php');
}
else {
	echo '<p>Information(s) manquante(s). Merci de remplir tous les champs.</p>';
}