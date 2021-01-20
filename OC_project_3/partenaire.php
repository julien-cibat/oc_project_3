<?php
session_start();
?>

<?php // Header
    include_once 'header.php';
?>

<!-- Contenu de la page -->
   	<section class="main">
        <!-- Présentation partenaire -->

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
        ?>
            <div>
                <img id="logo_acteur_page" src="img/<?php echo $donnees['logo']; ?>.png" alt="Logo <?php echo $donnees['acteur']; ?>">
           
                <h2><?php echo htmlspecialchars($donnees['acteur']); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($donnees['description'])); ?></p>           
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
        
        // Récupération note globale du partenaire

        $req = $bdd->prepare('SELECT SUM(vote) AS sum_vote FROM votes WHERE id_acteur = ?');
        $req->execute(array($_GET['page']));

        $donnees = $req->fetch();
        $vote_counter = $donnees['sum_vote'];
        // Fin de requête
        $req->closeCursor();
        ?>

        <div class="commentaires_menu">
            <h2>
                <?php 
                if($comments_counter <= 1)
                {
                    echo $comments_counter . ' commentaire'; 
                }
                else
                {
                    echo $comments_counter . ' commentaires'; 
                }                
                ?>                    
            </h2>
            <button><a href="commentaire.php?page=<?php echo $_GET['page']; ?>">Commenter</a></button>
            <button><strong><?php echo $vote_counter; ?></strong></button>
            <button><a href="">Like</a></button>
            <button><a href="">Dislike</a></button>
        </div>       
        
        <div class="commentaires_list">
            <?php

            // Affichage des commentaires associés au partenaire
            $req = $bdd->prepare('SELECT id_post, id_user, id_acteur, post, DATE_FORMAT(date_commentaire, "%d/%m/%Y à %H:%imin") AS date_comments FROM posts WHERE id_acteur = ?');
            $req->execute(array($_GET['page']));

            while ($donnees = $req->fetch())
            {
                $user = $donnees['id_user'];
                $date_commentaire = $donnees['date_comments']; 
                $commentaire = $donnees['post'];             

                // Récupération Username (users) associés à id_user (posts)
                $req = $bdd->prepare('SELECT usersUsername AS username FROM users WHERE usersId = ?');
                $req->execute(array($user));

                $donnees = $req->fetch();

                ?>

                <div class="commentaires_snapshot">                
                    <p><strong><?php echo htmlspecialchars($donnees['username']); ?></strong></p>
                    <p class="published">Publié le <?php echo htmlspecialchars($date_commentaire); ?></p>            
                    <p><?php echo nl2br(htmlspecialchars($commentaire)); ?></p>              
                </div>

                <?php
                // Fin de requête - table users
                $req->closeCursor();
                ?>

            <?php
            }       

            // Fin de requête - table posts
            $req->closeCursor();
            ?> 
        </div>        
    </section>    	 

<?php // Footer
    include_once 'footer.php';
?>