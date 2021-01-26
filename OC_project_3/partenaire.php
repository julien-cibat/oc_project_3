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
        $req1 = $bdd->prepare('SELECT * FROM acteurs WHERE id_acteur = ?');
        $req1->execute(array($_GET['page']));
        
        $donnees_acteur = $req1->fetch();

        if (empty($donnees_acteur)) {
            echo 'Ce partenaire n\'existe pas';
        }
        else {
        ?>
            <div>
                <img id="logo_acteur_page" src="img/<?php echo $donnees_acteur['logo']; ?>.png" alt="Logo <?php echo $donnees_acteur['acteur']; ?>">

                <p class="alert">
                <?php
                if (isset($_GET['error']) AND $_GET['error'] == 'alreadycommented') {
                    echo 'Commentaire déjà présent';
                }
                elseif (isset($_GET['status']) AND $_GET['status'] == 'votedeleted') {
                    echo 'Vote supprimé';
                }
                elseif (isset($_GET['status']) AND $_GET['status'] == 'voteupdates') {
                    echo 'Vote mis à jour';
                }
                elseif (isset($_GET['status']) AND $_GET['status'] == 'newvoteadded') {
                    echo 'Vote bien enregistré';
                }                  
                ?>                    
                </p>
           
                <h2><?php echo htmlspecialchars($donnees_acteur['acteur']); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($donnees_acteur['description'])); ?></p>           
            </div>
        <?php
        }
        ?>

        <?php // Libération du curseur pour prochaine requête
        $req1->closeCursor();    
        ?>             

    </section>                     

	<section class="commentaires">
        <!-- Bloc commentaires + votes -->
        <?php // Récupération nombres de commentaires du partenaire
        $req2 = $bdd->prepare('SELECT COUNT(post) AS nb_comments FROM posts WHERE id_acteur = ?');
        $req2->execute(array($_GET['page']));

        $donnees = $req2->fetch();
        $comments_counter = $donnees['nb_comments'];
        // Fin de requête
        $req2->closeCursor();
        
        // Récupération avis positif du partenaire
        $req3 = $bdd->prepare('SELECT COUNT(vote) AS likes FROM votes WHERE id_acteur = ? AND vote = 1');
        $req3->execute(array($_GET['page']));

        $donneesLikes = $req3->fetch();
        $likes_counter = $donneesLikes['likes'];
        // Fin de requête
        $req3->closeCursor();
        
        // Récupération avis négatif du partenaire
        $req4 = $bdd->prepare('SELECT COUNT(vote) AS dislikes FROM votes WHERE id_acteur = ? AND vote = -1');
        $req4->execute(array($_GET['page']));

        $donneesDislikes = $req4->fetch();
        $dislikes_counter = $donneesDislikes['dislikes'];
        // Fin de requête
        $req4->closeCursor();
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
            <button class="CTAsettings"><a href="votes.php?page=<?php echo $_GET['page']; ?>&vote=1 ">Like</a></button>           
            <button><strong><?php echo $likes_counter; ?></strong></button>
            <button class="CTAsettings"><a href="votes.php?page=<?php echo $_GET['page']; ?>&vote=-1 ">Dislike</a></button>  
            <button><strong><?php echo $dislikes_counter; ?></strong></button>
        </div>
        
        <div class="commentaires_list">          
            <?php

            // Affichage des commentaires associés au partenaire
            $req5 = $bdd->prepare('SELECT id_post, id_user, id_acteur, post, DATE_FORMAT(date_commentaire, "%d/%m/%Y à %H:%imin") AS date_comments FROM posts WHERE id_acteur = ?');
            $req5->execute(array($_GET['page']));

            while ($donnees5 = $req5->fetch())
            {
                $user = $donnees5['id_user'];
                $date_commentaire = $donnees5['date_comments']; 
                $commentaire = $donnees5['post'];             

                // Récupération Username (users) associés à id_user (posts)
                $req6 = $bdd->prepare('SELECT usersUsername AS username FROM users WHERE usersId = ?');
                $req6->execute(array($user));

                $donneesUser = $req6->fetch();

                ?>

                <div class="commentaires_snapshot">                
                    <p><strong><?php echo htmlspecialchars($donneesUser['username']); ?></strong></p>
                    <p class="published">Publié le <?php echo htmlspecialchars($date_commentaire); ?></p>            
                    <p><?php echo nl2br(htmlspecialchars($commentaire)); ?></p>              
                </div>

                <?php
                // Fin de requête - table users
                $req6->closeCursor();
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