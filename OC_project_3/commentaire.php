<?php // Date Time Zone
date_default_timezone_set('Europe/Paris');

// Connexion Database    
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

// Vérification si commentaire user déjà existant
$req1 = $bdd->prepare('SELECT post AS comment FROM posts WHERE id_user = :id_user & id_acteur = :id_acteur');
$req1->execute(array(
    ':id_user' => $_SESSION['id'],
    ':id_acteur' => $_GET['page'],
    ));

$donnees_comments = $req1->fetch();
$user_comment = $donnees_comments['comment'];

if (!empty($user_comment)) {
    $userid = $_SESSION['id'];
    $acteur = $_GET['page'];    
    header("location: partenaire.php?error=alreadycommented&userid=$userid&acteur=$acteur");
}

// Fin de requête
$req1->closeCursor();            
?> 

<!-- Contenu de la page -->
	<section class="main">
    <!-- Commentaire page init -->

    <?php // Affichage partenaire sélectionné page précédente
    $req = $bdd->prepare('SELECT * FROM acteurs WHERE id_acteur = ?');
    $req->execute(array($_GET['page']));
    $donnees = $req->fetch();

    if (empty($donnees)) {
        echo 'Ce partenaire n\'existe pas';
    }
    else {
    	$today = date("j F Y, G:i");
    	$acteur = $donnees['acteur'];
    	$id_acteur = $donnees['id_acteur'];
    	$id_user = $_SESSION['id'];   
    ?>

        <h1>Postez votre commentaire à propos de <em><?php echo $acteur; ?></em></h1>
    	<p>En tant que : <strong><?php echo $_SESSION['Username']; ?></strong></p>
    	<p>Date : <strong><?php echo $today; ?></strong></p>
        
    <?php
    }
    ?>    
    
    <?php // Libération du curseur pour prochaine requête
    $req->closeCursor();    
    ?>

</section>

<section class="comment_section">
		<!-- Espace Commentaire -->  

    <div class="comment_area">
	    <form method="post" action="includes/commentaire_post.php">
	    	<?php
		    	echo '<input type="hidden" name="id_user" value="' . $id_user . '" />'."\n";       
		        echo '<input type="hidden" name="id_acteur" value="' . $id_acteur . '" />'."\n";
	    	?> 	
			<p><textarea name="post" placeholder="Ecrivez votre commentaire ici..."></textarea></p>
	        <p><input type="submit" name="submit" value="Envoyer"/></p>  		
		</form>
	</div>

	<div class="comment_notice">
        <img src="img/gbaf_logo.jpg" alt="Logo GBAF">                
        <p>Votre avis nous est précieux pour aider l'ensemble de la communauté GBAF<br/> 
        à mieux référencer les offres de nos partenaires.</p>
        <p>Merci pour votre contribution.</p>           
    </div>
</section>

<?php // Footer
include_once 'footer.php';
?>