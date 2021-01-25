<?php 
session_start();

include_once 'header.php';
?>

	<div class="login_signup_interface">
		<section class="main">
			<h2>Inscription</h2>
			<div>
				<form class="signup_form" action="includes/signup_post.php" method="post">					
					<input type="text" name="nom" placeholder="Nom..." />					
					<input type="text" name="prenom" placeholder="Prenom..." />
					<input type="text" name="username" placeholder="Identifiant..." />					
					<input type="password" name="password" placeholder="Mot de passe..." />
					<input type="text" name="question" placeholder="Question secrète ?" />					
					<input type="text" name="reponse" placeholder="Réponse à la question secrète..." />					
					<button type="submit" name="submit">Valider</button>					
				</form>
			</div>
		</section>

		<section class="login-signup_options">			
			
			<h4>Vous avez déjà un compte GBAF ?</h4>
			<a href="login.php">Cliquez sur ce lien pour vous connecter au portail</a>
			
		</section>
	</div>

<?php
include_once 'footer.php';
?>
