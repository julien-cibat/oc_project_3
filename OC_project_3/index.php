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
        <!-- Présentation -->
        <h1>Groupement bancaire GBAF</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Pellentesque sit amet porttitor eget dolor morbi. Euismod quis viverra nibh cras pulvinar mattis nunc sed blandit. Auctor neque vitae tempus quam. Orci porta non pulvinar neque laoreet suspendisse interdum consectetur. Massa id neque aliquam vestibulum morbi blandit. Imperdiet massa tincidunt nunc pulvinar sapien et ligula. Tristique senectus et netus et malesuada. Sed elementum tempus egestas sed sed risus. Eget arcu dictum varius duis at. Nibh venenatis cras sed felis eget. Id velit ut tortor pretium viverra. Scelerisque mauris pellentesque pulvinar pellentesque habitant. Vitae elementum curabitur vitae nunc sed velit dignissim. Placerat vestibulum lectus mauris ultrices eros in.</p>

        <figure>
            <img src="img/gbaf_logo.jpg" alt="Logo GBAF">
        </figure>
        <figcaption>Groupement Banque Assurance Français</figcaption>

    </section>                     

	<section class="acteurs">
        <!-- Acteurs bancaires -->
        <h2>Acteurs & partenaires</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Pellentesque sit amet porttitor eget dolor morbi. Euismod quis viverra nibh cras pulvinar mattis nunc sed blandit. Auctor neque vitae tempus quam. Orci porta non pulvinar neque laoreet suspendisse interdum consectetur. Massa id neque aliquam vestibulum morbi blandit. </p>

        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Pellentesque sit amet porttitor eget dolor morbi. Euismod quis viverra nibh cras pulvinar mattis nunc sed blandit. Auctor neque vitae tempus quam. Orci porta non pulvinar neque laoreet suspendisse interdum consectetur. Massa id neque aliquam vestibulum morbi blandit. Imperdiet massa tincidunt nunc pulvinar sapien et ligula. Tristique senectus et netus et malesuada. Sed elementum tempus egestas sed sed risus. Eget arcu dictum varius duis at. Nibh venenatis cras sed felis eget. Id velit ut tortor pretium viverra. Scelerisque mauris pellentesque pulvinar pellentesque habitant. Vitae elementum curabitur vitae nunc sed velit dignissim. Placerat vestibulum lectus mauris ultrices eros in.</p>

        <div class="acteurs_list">
            <?php // Affichage liste des acteurs

            $req = $bdd->query('SELECT * FROM acteurs ORDER BY id_acteur');
            
            while ($donnees = $req->fetch()) 
            {
            ?>

            <div class="acteur_snapshot">         
                
                <a href="partenaire.php?page=<?php echo $donnees['id_acteur']; ?>">
                    <img id="logo_acteur" src="img/<?php echo $donnees['logo']; ?>.png" alt="Logo <?php echo $donnees['acteur']; ?>">
                </a>

                <div>       
                    <h3><?php echo htmlspecialchars($donnees['acteur']); ?></h3>
                    <p><?php echo substr(htmlspecialchars($donnees['description']), 0, 120) . '...'; ?></p>
                </div>    
                
                <button><a href="partenaire.php?page=<?php echo $donnees['id_acteur']; ?>">Lire la suite</a></button>
                
            </div>

            <?php
            }

            // Fin de requête
            $req->closeCursor();
            ?> 
        </div>        
    </section>    	 

<?php // Footer
include_once 'footer.php';
?>