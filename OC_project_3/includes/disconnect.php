<?php // Destruction des informations de Session
session_start();
session_unset();
session_destroy();
 
$_SESSION = array();

// Redirection vers page login
header('Location: ../login.php');
exit();