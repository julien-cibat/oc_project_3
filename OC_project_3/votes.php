<?php // Connexion Database    
try {
    $bdd = new PDO('mysql:host=localhost;dbname=project_3;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}

//// STEP 1 --> Traitement données ////
// Récupération des infos de navigation de l'utilisateur
session_start();

$userid = $_SESSION['id'];
$acteurid = $_GET['page'];
$uservote = $_GET['vote'];

// Récupération des infos utilisateur en BDD --> table votes
$req1 = $bdd->prepare('SELECT * FROM votes WHERE id_user = :id_user AND id_acteur = :id_acteur');
$req1->execute(array(
    ':id_user' => $userid,
    ':id_acteur' => $acteurid,
    ));

$donnees_votes = $req1->fetch();
$registered_vote = $donnees_votes['vote'];      

// Fin de requête
$req1->closeCursor(); 

//// STEP 2 --> ARBITRAGE (3 cas possibles) ////
// Cas 1 : Vote existant et identique en BDD --> DELETE FROM
if ($donnees_votes == true AND $registered_vote == $uservote) {
	$req2 = $bdd->prepare('DELETE FROM votes WHERE id_user = :id_user AND id_acteur = :id_acteur');
	$req2->execute(array(
    ':id_user' => $userid,
    ':id_acteur' => $acteurid
    ));

    // Fin de requête
	$req2->closeCursor(); 

	header("location: partenaire.php?page=$acteurid&status=votedeleted&value=$uservote");
}
// Cas 2 : Vote existant mais différent en BDD --> UPDATE
elseif ($donnees_votes == true AND $registered_vote !== $uservote) {
	$req3 = $bdd->prepare('UPDATE votes SET vote = :user_vote WHERE id_user = :id_user AND id_acteur = :id_acteur');
	$req3->execute(array(
    ':id_user' => $userid,
    ':id_acteur' => $acteurid,
    ':user_vote' => $uservote
    ));

    // Fin de requête
	$req3->closeCursor(); 
	
	header("location: partenaire.php?page=$acteurid&status=voteupdated&value=$uservote");
}
// Cas 3 : Vote inexistant en BDD --> INSERT INTO
else {
	$req4 = $bdd->prepare('INSERT INTO votes(id_user, id_acteur, vote) VALUES(:id_user, :id_acteur, :user_vote)');
	$req4->execute(array(
    ':id_user' => $userid,
    ':id_acteur' => $acteurid,
    ':user_vote' => $uservote
    ));

    // Fin de requête
	$req4->closeCursor(); 

	header("location: partenaire.php?page=$acteurid&status=newvoteadded&value=$uservote");
}