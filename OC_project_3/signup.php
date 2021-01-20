<?php
	include_once 'header.php';
?>

	<section class="signup-form">
		<h2>Inscription</h2>
		<div class="signup-form-form">
			<form action="includes/signup.inc.php" method="post">
				<input type="text" name="name" placeholder="Name...">
				<input type="email" name="email" placeholder="Email...">
				<input type="text" name="username" placeholder="Username...">
				<input type="password" name="password" placeholder="Password...">
				<input type="password" name="passwordRepeat" placeholder="Repeat password...">
				<button type="submit" name="submit">Valider</button>
			</form>
		</div>
	</section>

	<?php
	if (isset($_GET['error'])) 
	{
		if ($_GET['error'] == "emptyinput")
		{
			echo '<p>Remplissez tous les champs</p>';
		}
		else if($_GET['error'] == "invalidusername")
		{
			echo '<p>Choisissez un bon username</p>';
		}
		else if($_GET['error'] == "passwordsdontmatch")
		{
			echo '<p>Les mots de passe ne sont pas identiques</p>';
		}
		else if($_GET['error'] == "usernametaken") // A changer stmt
		{
			echo '<p>xxxx</p>';
		}
		else if($_GET['error'] == "usernametaken")
		{
			echo '<p>xxxx</p>';
		}
		else if($_GET['error'] == "none")
		{
			echo '<p>xxxx</p>';
		}
	}
	?>

<?php
	include_once 'footer.php';
?>
