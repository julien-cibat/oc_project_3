<?php
// Connexion Database
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=project_3;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

// Ecriture dans la base à l'aide d'un requête préparée
if (!isset($_POST['?']))
{
	echo 'Merci de compléter votre profil afin d\'effectuer les modifications.';
	// Retour formulaire page précédente
	header("Location: ../settings.php");
}
else
{
	$req = $bdd->prepare('UPDATE users(usersNom, usersPrenom, usersUsername, usersPassword) VALUES(:nom, :prenom, :username, :password) WHERE usersId = ?') ;
    $req->execute(array(
        'nom' => ($_POST['nom']),
        'prenom' => ($_POST['prenom']),
        'username' => ($_POST['username']),
        'password' => ($_POST['password'])
        ));

    // Retour page partenaire concerné
    header("Location: ../settings.php");
}