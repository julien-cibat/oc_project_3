<?php
session_start();
date_default_timezone_set('Europe/Paris');
?>

<?php // Header
    include_once 'header.php';
?>

<!-- Contenu de la page -->
   	<section class="main">
        <!-- Commentaire page init -->

        <?php // Connexion DataBase
        try
        {
            $bdd = new PDO('mysql:host=localhost;dbname=project_3;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }

        // Affichage partenaire sélectionné page précédente
        $req = $bdd->prepare('SELECT * FROM acteurs WHERE id_acteur = ?');
        $req->execute(array($_GET['page']));
        $donnees = $req->fetch();

        if (empty($donnees))
        {
            echo 'Ce partenaire n\'existe pas';
        }
        else
        {
        	$today = date("j F Y, G:i");
        	$acteur = $donnees['acteur'];
        	$id_acteur = $donnees['id_acteur'];
        	$id_user = 2;   
        ?>

            <h1>Postez votre commentaire à propos de <em><?php echo $acteur; ?></em></h1>
        	<p>En tant que : <strong><?php echo 'UserName'; ?></strong></p>
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
				<p><textarea name="commentaire" placeholder="Ecrivez votre commentaire ici..."></textarea></p>
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