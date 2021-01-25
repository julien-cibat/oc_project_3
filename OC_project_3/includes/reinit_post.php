<?php // Connexion Database    
try {
    $bdd = new PDO('mysql:host=localhost;dbname=project_3;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}

//======================================================================
// VERIFICATION DES INFORMATIONS (RENOUVELLEMENT MOT DE PASSE)
//======================================================================

// Vérification formulaire complet
if (!empty($_POST['password'])) {	

	//======================================================================
	// ENREGISTREMENT USERSINFO EN DATABASE
	//======================================================================

	// Hachage du mot de passe
	$password = $_POST['password'];
	$userId = $_POST['userId'];
	$pass_hash = password_hash($password, PASSWORD_DEFAULT);

	// Insertion en BDD
	$req = $bdd->prepare('UPDATE users SET usersPassword = :userpassword WHERE usersId = :userid');
	$req->execute(array(
	    ':userpassword' => $pass_hash,
	    ':userid' => $userId
	    ));

	// Libération du curseur pour prochaine requête
	$req->closeCursor();

	// Redirection page login
	header('Location: ../login.php?info=passwordchanged');	
}
else {
	echo '<p>Merci de définir un nouveau mot de passe.</p>';
}
    	

