<?php
	include_once 'header.php';
?>

<section class="bloc_page">
	<div class="login_signin_interface">
		<section class="main">
			<h1>Mot de passe oublié</h1>
			<p>Merci de saisir votre identifiant personnel</p>

			<div class="login_form">
				<form action="secret.php" method="post">			
					<input type="text" name="username" placeholder="Identifiant..." />
					<button type="submit" name="submit">Valider</button>
				</form>
			</div>		
		</section>
	</div>
</section>	

<?php
include_once 'footer.php';
?>