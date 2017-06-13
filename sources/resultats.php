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
if (isset($_REQUEST["disponible"])) {
    $animal = recupererAnimal($_REQUEST["animal"]);
    $adresse = recupererAdresseDeUtilisateur($_SESSION["id"]);
    $resultats = rechercherGardien($_REQUEST["disponible"], $animal[0]["idEspece"], $adresse[0]["Lat"], $adresse[0]["Lng"], $_REQUEST["distance"]);
    if (count($resultats) < 1) {
        header('Location:rechercher.php?erreur=2');
        exit();
    }
    var_dump($resultats);
} else {
    header('Location:rechercher.php?erreur=1');
    exit();
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Résultats</title>
    </head>
    <body>
        <?php
        var_dump($_REQUEST);
        ?>
    </body>
</html>
