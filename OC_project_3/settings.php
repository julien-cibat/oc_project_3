<?php
session_start();
?>

<?php // Header
    include_once 'header.php';
?>

<?php // Connexion DataBase
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=project_3;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }
?>

<!-- Contenu de la page -->
   	<section class="main">
        <!-- Informations personnelles -->    
        <h1>Paramètres</h1>
        <h2>Informations personnelles</h2>

        <?php // Chargement des informations personnelles de l'utilisateur
        $req = $bdd->prepare('SELECT * FROM users WHERE usersId = ?');
        $req->execute(array(2));

        $donnees = $req->fetch();

        $nom = $donnees['usersNom'];
        $prenom = $donnees['usersPrenom'];
        $username = $donnees['usersUsername'];
        $password = $donnees['usersPassword'];
        $question = $donnees['usersQuestion'];
        $reponse = $donnees['usersReponse'];
        $date_inscription = $donnees['usersInscription_date'];

        // Libération du curseur pour prochaine requête
        $req->closeCursor();    
        ?>

        <!-- Espace Commentaire -->  
        <div>		    
			<form method="post" action="settings_post.php">
				<p><label>Nom</label> <input type="text" name="nom" placeholder="<?php echo $nom; ?>" /></p>
		        <p><label>Prenom</label> <input type="text" name="prenom" placeholder="<?php echo $prenom; ?>" /></p>
		        <p><label>Pseudo</label> <input type="text" name="username" placeholder="<?php echo $username; ?>" /></p>
		        <p><label>Password</label> <input type="password" name="password" placeholder="<?php echo $password; ?>" /></p>
		        <p><label>Inscrit depuis le : </label> <input type="text" name="date_incription" placeholder="<?php echo $date_inscription; ?>" /></p>  
		        <p><input type="submit" name="cancel" value="Annuler"/></p>
		        <p><input type="submit" name="submit" value="Valider"/></p>   		
			</form>
		</div>		
	</section>


        