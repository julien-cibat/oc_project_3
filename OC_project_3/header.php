<?php // Ouverture de Session
session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap">
		<link rel="stylesheet" href="css/style.css">
		<title>GBAF | Extranet</title>		
	</head>
	
	<body>
		<!--Header & Menu-->
		<header>
			<a id="logo" href="index.php"><img src="img/gbaf_logo_mini.jpg" alt="Logo GBAF" title="Retour à l'accueil"></a>			

			<!--Barre de navigation-->
			<nav id="menu">				
				<?php
					if (isset($_SESSION['username'])) {
						echo '<div><a class="element1" href="index.php" title="Retour à l\'accueil">Accueil</a></div>';
						echo '<div><a class="element3" href="includes/disconnect.php" title="Se déconnecter">Deconnexion</a></div>';
						echo '<div><a class="element4" href="settings.php" title="Paramètres utilisateur">' . $_SESSION['prenom'] . ' ' . $_SESSION['nom'] . '</a></div>';
					}
					else {
						echo '<div><a class="element2" href="signup.php">Inscription</a></div>';
						echo '<div><a class="element3" href="login.php">Connexion</a></div>';						
					}
				?>						
			</nav>

		</header>

