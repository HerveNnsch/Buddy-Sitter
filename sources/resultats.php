<!DOCTYPE html>
<!--
Auteur: Hervé Neuenschwander
But: Affiche les gardien disponibles pour un gardiennage
-->
<?php
session_start();
require './dao.php';

if (!isset($_SESSION["id"])) {
    header('Location:index.php');
    exit();
}

$resultats = rechercherGardien($_REQUEST["disponible"], 1, 1, 1);
var_dump($resultats);

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        var_dump($_REQUEST);
        ?>
    </body>
</html>
