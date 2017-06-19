 <?php

/* 
 * Auteur: Hervé Neuenschwander
 * But: Déconnecte un utilisateur
 * Date: 19.06.2017
 */
session_start();
$_SESSION=[];
session_destroy();
header('Location: index.php');