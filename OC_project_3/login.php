<?php 
session_start();

include_once 'header.php';
?>

	<div class="login_interface">
		<section class="main">
			<h1>Connexion</h1>

			<div class="login_form">
				<form action="includes/login_post.php" method="post">			
					<input type="text" name="username" placeholder="Identifiant..." />
					<input type="password" name="password" placeholder="Mot de passe..." />
					<button type="submit" name="submit">Se connecter</button>
				</form>
			</div>

			<figure>
            	<img src="img/gbaf_logo.jpg" alt="Logo GBAF">
        	</figure>		
		</section>

		<section class="login-signup_options">		
			
			<h4>Vous n'avez pas encore de compte GBAF ?</h4>
			<a href="signup.php">Cliquez sur ce lien pour en créer un</a>			
			
			<h4>Vous avez oublié votre mot de passe ?</h4>
			<a href="recovery.php">Cliquez sur ce lien pour le réinitialiser</a>
					
		</section>
	</div>	

<?php // Footer
	include_once 'footer.php';
?>