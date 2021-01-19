<?php
session_start();
?>

<?php // Header
    include_once 'header.php';
?>

<!-- Contenu de la page -->
   	<section class="presentation">
        <!-- Présentation -->
        <h1>Postez votre commentaire</h1>

	    <form method="post" action="commentaire_post.php">
	    	<p><input type="hidden" name="id_post" value="$_GET['page']"></p>
			<p><input type="hidden" name="id_user"/></p>	        
	        <p><input type="hidden" name="id_acteur"/></p>
	        <p><input type="hidden" name="date_commentaire" value='DATETIME()'></p> 
	        <p><textarea name="post" rows="10" cols="50"></textarea></p>
	        <p><input type="submit" name="submit" value="Envoyer"/></p>  		
		</form>

<?php // Footer
    include_once 'footer.php';
?>