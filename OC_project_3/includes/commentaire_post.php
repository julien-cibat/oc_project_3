<?php
// Connexion Database
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

// Ecriture dans la base à l'aide d'un requête préparée

$req = $bdd->prepare('INSERT INTO commentaires(auteur, commentaire, id_billet, date_commentaire) VALUES(:auteur, :commentaire, :id_billet, NOW())');
    $req->execute(array(
        'auteur' => ($_POST['auteur']),
        'commentaire' => ($_POST['commentaire']),
        'id_billet' => $_POST['page']
        ));

// Retour formulaire page précédente

header('Location: commentaire.php');

?>