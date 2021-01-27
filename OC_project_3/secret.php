<?php // Connexion Database    
try {
    $bdd = new PDO('mysql:host=localhost;dbname=project_3;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}

// Header
include_once 'header.php';

// Chargement des informations personnelles de l'utilisateur
$req = $bdd->prepare('SELECT usersId, usersUsername, usersQuestion FROM users WHERE usersUsername = ?');
$req->execute(array($_POST['username']));

$donnees = $req->fetch();

$username = $donnees['usersUsername'];
$question = $donnees['usersQuestion'];

// Fin de requête
$req->closeCursor();
?> 

<section class="bloc_page">	
	<section class="main">
		<h1>Récupération de mot de passe</h1>
		<p>Afin de réinitialiser votre mot de passe, merci de confirmer votre identité en répondant à la question suivante :</p>

		<p><strong>Question secrète :</strong> <em><?php echo $question; ?></em></p>
		
		<div class="login_form">
			<form action="includes/secret_post.php" method="post">
				<input type="hidden" name="userId" value="<?php echo $donnees['usersId']; ?>" />			
				<input type="text" name="reponse" placeholder="Votre réponse..." />
				<button type="submit" name="submit">Valider</button>
			</form>
		</div>		
	</section>
</section>	

<?php // Footer
include_once 'footer.php';
?>