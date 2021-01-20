<?php
// Connexion Database
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=project_3;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

// Ecriture dans la base à l'aide d'un requête préparée

if (!isset($_POST['post']))
{
	echo 'Merci de compléter le formulaire avant de valider.';
	// Retour formulaire page précédente
	header("Location: ../commentaire.php?page=".$_POST['id_acteur']);
}
else
{
	$req = $bdd->prepare('INSERT INTO posts(id_user, id_acteur, date_commentaire, post) VALUES(:id_user, :id_acteur, NOW(), :post)');
    $req->execute(array(
        'id_user' => ($_POST['id_user']),
        'id_acteur' => ($_POST['id_acteur']),
        'post' => ($_POST['commentaire'])
        ));
    // Retour page partenaire concerné
    header("Location: ../partenaire.php?page=".$_POST['id_acteur']);
}