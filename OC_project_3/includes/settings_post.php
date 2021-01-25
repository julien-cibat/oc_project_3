<?php // Connexion Database    
try {
    $bdd = new PDO('mysql:host=localhost;dbname=project_3;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}

// Ecriture dans la base à l'aide d'un requête préparée
if (empty($_POST['nom']) OR empty($_POST['prenom']) OR empty($_POST['username']) OR empty($_POST['question']) OR empty($_POST['reponse']))
{
    // Retour formulaire page précédente
    header("Location: ../settings.php?error=missinginput");
}
else {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $username =  $_POST['username'];
    $question = $_POST['question'];
    $reponse = $_POST['reponse'];

    $userid = $_POST['userId'];    

    // Update des informations personnelles en BDD    
    $req = $bdd->prepare('UPDATE users SET usersNom = :nom, usersPrenom = :prenom, usersUsername = :username, usersQuestion = :userquestion, usersReponse = :userreponse WHERE usersId = :userid');

    // Intégration en BDD
    $req->execute(array(
    ':nom' => $nom,
    ':prenom' => $prenom,
    ':username' => $username,
    ':userquestion' => $question,
    ':userreponse' => $reponse,
    ':userid' => $userid
    ));

    // Retour page partenaire concerné
    header("Location: ../settings.php?info=confirmation");   
}