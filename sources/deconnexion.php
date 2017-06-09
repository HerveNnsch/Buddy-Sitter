 <?php

/* 
 * Auteur: Hervé Neuenschwander
 * But: Déconnecte un utilisateur
 */
session_start();
$_SESSION=[];
session_destroy();
header('Location: index.php');