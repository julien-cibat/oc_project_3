<?php // Connexion Database    
try {
    $bdd = new PDO('mysql:host=localhost;dbname=project_3;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}

//======================================================================
// VERIFICATION DES INFORMATIONS (QUESTION SECRETE)
//======================================================================

if (empty($_POST['reponse'])) {
	// Retour formulaire page précédente
	header("Location: ../secret.php?error=invalidform");
}
else {
    // Chargement des informations personnelles de l'utilisateur
	$req = $bdd->prepare('SELECT usersReponse FROM users WHERE usersId = ?');
	$req->execute(array($_POST['userId']));

	$donnees = $req->fetch();
	$userid = $_POST['userId'];

	if ($donnees['usersReponse'] == $_POST['reponse']) {
		// Redirection page création nouveau password
    	header("Location: ../reinitialization.php?user=$userid");
	}
	else {
		// Retour page question secrète
    	header("Location: ../secret.php?error=invalidresponse");
	}  
}