<?php
	include_once 'header.php';
?>

	<section class="signup-form">
		<h2>Connexion</h2>
		<div class="signup-form-form">
			<form action="includes/login.inc.php" method="post">			
				<input type="text" name="name" placeholder="Username/Email...">
				<input type="password" name="password" placeholder="Password...">
				<button type="submit" name="submit">Se connecter</button>
			</form>
		</div>
	</section>

<?php
	include_once 'footer.php';
?>