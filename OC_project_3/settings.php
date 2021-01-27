<?php // Connexion Database    
try {
    $bdd = new PDO('mysql:host=localhost;dbname=project_3;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}

// Header
include_once 'header.php';

// Vérification autorisation accès
if(!$_SESSION['username']) {
    header("location: login.php");
}
?>

<!-- Contenu de la page -->
<section class="bloc_page">
   	<section class="main">
        <!-- Informations personnelles -->    
        <h1>Paramètres utilisateur</h1>
        <p class="alert"><?php
        if (isset($_GET['info']) AND $_GET['info'] == 'confirmation') {
            echo 'Modifications enregistrées';
        }        
        ?></p><br/>

        <?php // Chargement des informations personnelles de l'utilisateur
        $req = $bdd->prepare('SELECT usersId, usersNom, usersPrenom, usersUsername, usersQuestion, usersReponse, DATE_FORMAT(usersInscription_date, "%d %M %Y") AS date FROM users WHERE usersId = ?');
        $req->execute(array($_SESSION['id']));

        $donnees = $req->fetch();

        $userId = $donnees['usersId'];
        $nom = $donnees['usersNom'];
        $prenom = $donnees['usersPrenom'];
        $username = $donnees['usersUsername'];
        $question = $donnees['usersQuestion'];
        $reponse = $donnees['usersReponse'];

        $date_inscription = $donnees['date'];

        // Libération du curseur pour prochaine requête
        $req->closeCursor();    
        ?>

        <!-- Espace Commentaire -->  
        <div class="settings_list">		    
			<form method="post" action="includes/settings_post.php">
				<p><label>Nom</label> <input type="text" name="nom" value="<?php echo $nom; ?>" /></p>
		        <p><label>Prenom</label> <input type="text" name="prenom" value="<?php echo $prenom; ?>" /></p>
		        <p><label>Pseudo</label> <input type="text" name="username" value="<?php echo $username; ?>" /></p><br/>
		        <p><label>Mot de passe : </label> <strong><a href="reinitialization.php?user=<?php echo $_SESSION['id']; ?>">Renouveler le mot de passe</a></strong></p><br/>
                <p><label>Question secrète</label> <input type="text" name="question" value="<?php echo $question; ?>" /></p>
                <p><label>Réponse</label> <input type="password" name="reponse" value="<?php echo $reponse; ?>" /></p><br/>
		        <p><label>Inscrit depuis le : </label><?php echo ($date_inscription); ?></p>
                <p><strong><a href="includes/disconnect.php">Se déconnecter</a></strong></p>
                <p><input type="hidden" name="userId" value="<?php echo $userId; ?>" /></p>
                <p><input type="hidden" name="password_old" value="<?php echo $password; ?>" /></p>   
		        <div>
                    <button class="CTAsettings"><a href=index.php>Annuler</a></button>                 
                    <input class="CTAsettings" type="submit" name="submit" value="Valider"/>
                </div>   		
			</form>                       
		</div>		
	</section>
</section>

<?php // Footer
include_once 'footer.php';
?>