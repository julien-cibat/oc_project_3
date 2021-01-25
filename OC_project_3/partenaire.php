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
   	<section class="main">
        <!-- Présentation partenaire -->

        <?php // Affichage partenaire sélectionné page précédente
        $req = $bdd->prepare('SELECT * FROM acteurs WHERE id_acteur = ?');
        $req->execute(array($_GET['page']));
        
        $donnees_acteur = $req->fetch();

        if (empty($donnees_acteur)) {
            echo 'Ce partenaire n\'existe pas';
        }
        else {
        ?>
            <div>
                <img id="logo_acteur_page" src="img/<?php echo $donnees_acteur['logo']; ?>.png" alt="Logo <?php echo $donnees_acteur['acteur']; ?>">
           
                <h2><?php echo htmlspecialchars($donnees_acteur['acteur']); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($donnees_acteur['description'])); ?></p>           
            </div>
        <?php
        }
        ?>

        <?php // Libération du curseur pour prochaine requête
        $req->closeCursor();    
        ?>             

    </section>                     

	<section class="commentaires">
        <!-- Bloc commentaires + votes -->
        <?php // Récupération nombres de commentaires du partenaire
        $req = $bdd->prepare('SELECT COUNT(post) AS nb_comments FROM posts WHERE id_acteur = ?');
        $req->execute(array($_GET['page']));

        $donnees = $req->fetch();
        $comments_counter = $donnees['nb_comments'];
        // Fin de requête
        $req->closeCursor();
        
        // Récupération avis positif du partenaire
        $req1 = $bdd->prepare('SELECT COUNT(vote) AS likes FROM votes WHERE id_acteur = ? AND vote = 1');
        $req1->execute(array($_GET['page']));

        $donneesLikes = $req1->fetch();
        $likes_counter = $donneesLikes['likes'];
        // Fin de requête
        $req1->closeCursor();
        
        // Récupération avis négatif du partenaire
        $req2 = $bdd->prepare('SELECT COUNT(vote) AS dislikes FROM votes WHERE id_acteur = ? AND vote = -1');
        $req2->execute(array($_GET['page']));

        $donneesDislikes = $req2->fetch();
        $dislikes_counter = $donneesDislikes['dislikes'];
        // Fin de requête
        $req2->closeCursor();
        ?>

        <div class="commentaires_menu">
            <h3>
                <?php // Affichage nombre commentaire(s)
                if($comments_counter <= 1) {
                    echo $comments_counter . ' commentaire'; 
                }
                else {
                    echo $comments_counter . ' commentaires'; 
                }                
                ?>                    
            </h3>
            <button class="CTAsettings"><a href="commentaire.php?page=<?php echo $_GET['page']; ?> ">Commenter</a></button>
            <button class="CTAsettings"><a href=index.php>Like</a></button>           
            <button><strong><?php echo $likes_counter; ?></strong></button>
            <button class="CTAsettings"><a href=index.php>Dislike</a></button>  
            <button><strong><?php echo $dislikes_counter; ?></strong></button>
        </div>       
        
        <div class="commentaires_list">
            <?php

            // Affichage des commentaires associés au partenaire
            $req4 = $bdd->prepare('SELECT id_post, id_user, id_acteur, post, DATE_FORMAT(date_commentaire, "%d/%m/%Y à %H:%imin") AS date_comments FROM posts WHERE id_acteur = ?');
            $req4->execute(array($_GET['page']));

            while ($donnees4 = $req4->fetch())
            {
                $user = $donnees4['id_user'];
                $date_commentaire = $donnees4['date_comments']; 
                $commentaire = $donnees4['post'];             

                // Récupération Username (users) associés à id_user (posts)
                $req5 = $bdd->prepare('SELECT usersUsername AS username FROM users WHERE usersId = ?');
                $req5->execute(array($user));

                $donneesUser = $req5->fetch();

                ?>

                <div class="commentaires_snapshot">                
                    <p><strong><?php echo htmlspecialchars($donneesUser['username']); ?></strong></p>
                    <p class="published">Publié le <?php echo htmlspecialchars($date_commentaire); ?></p>            
                    <p><?php echo nl2br(htmlspecialchars($commentaire)); ?></p>              
                </div>

                <?php
                // Fin de requête - table users
                $req4->closeCursor();
                ?>

            <?php
            }       

            // Fin de requête - table posts
            $req5->closeCursor();
            ?> 
        </div>        
    </section>    	 

<?php // Footer
include_once 'footer.php';
?>