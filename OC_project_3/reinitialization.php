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
$req = $bdd->prepare('SELECT usersId, usersUsername FROM users WHERE usersId = ?');
$req->execute(array($_GET['user']));

$donnees = $req->fetch();

?>

	<div class="login_signin_interface">
		<section class="main">
			<h1>Nouveau mot de passe</h1>
			<p>Merci de définir votre nouveau mot de passe pour <strong><?php echo $donnees['usersUsername']; ?></strong></p>

			<div class="login_form">
				<form action="includes/reinit_post.php" method="post">			
					<input type="password" name="password" placeholder="Nouveau mot de passe..." />
					<input type="hidden" name="userId" value="<?php echo $donnees['usersId']; ?>" />
					<button type="submit" name="submit">Valider</button>
				</form>
			</div>		
		</section>	

	</div>	

<?php // Footer
include_once 'footer.php';
?>