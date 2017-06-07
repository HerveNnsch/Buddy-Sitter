<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
require './dao.php';
$lesraces = recupererRaces();
if (isset($_REQUEST["btnsave"])) {
    $animal = inscriptionAnimal($_REQUEST["races"], $_REQUEST["nom"], $_REQUEST["date"], $_REQUEST["remarques"], $_SESSION["id"]);
    if (count($animal) > 0) {
        header('Location:profil.php');
    } else {
        echo "problème pendant l'insertion";
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ajouter un animal</title>
    </head>
    <body>
        <form action="ajoutanimal.php" method="POST">
            <label>Espèce :</label>
            <select name="races">
                <?php
                foreach ($lesraces as $race) {
                    echo "<option value=" . $race["idEspece"] . ">" . $race["NomEspece"] . "</option>";
                }
                ?>
            </select>
            <br/>
            <label>Date de naissance :</label><input type="date" name="date" required=""><br/>
            <label>Nom :</label><input type="text" name="nom" required=""><br/>
            <label>Remaques :</label><input type="text" name="remarques" required=""><br/>
            <input type="submit" value="S'enregistrer" name="btnsave" >
        </form>
    </body>
</html>
