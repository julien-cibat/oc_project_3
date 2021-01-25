<?php // Connexion DataBase
defined('BASEPATH') OR exit('No direct script access allowed');
    
$host = 'localhost';
$user = 'root';
$password = 'root';
$dbname = 'project_3';
$dsn = '';

try {
	$dsn = 'mysql:host' . $host . ';dbname=' . $dbname . ';charset=utf8';

	$bdd = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}