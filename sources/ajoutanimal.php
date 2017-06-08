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
        <link href="startbootstrap-freelancer-gh-pages/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="startbootstrap-freelancer-gh-pages/css/freelancer.min.css" rel="stylesheet" type="text/css">
        <link href="startbootstrap-freelancer-gh-pages/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <title>Ajouter un animal</title>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-custom" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="index.php">Buddy-Sitter</a>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="profil.php">Profil</a></li>
                        <li><a href="deconnexion.php">Déconnexion</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="row">
            <div class="col-lg-10 col-lg-offset-2">
                <form action="ajoutanimal.php" method="POST">
                    <fieldset>
                        <legend>Ajout d'un animal</legend>
                        <div class='row'>
                            <div class="col-lg-2"><label>Espèce :</label></div>
                            <div class="col-lg-10"><select name="races">
                                    <?php
                                    foreach ($lesraces as $race) {
                                        echo "<option value=" . $race["idEspece"] . ">" . $race["NomEspece"] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2"><label>Date de naissance :</label></div>
                            <div class="col-lg-10"><input type="date" name="date" required=""></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2"><label>Nom :</label></div>
                            <div class="col-lg-10"><input type="text" name="nom" required=""></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2"><label>Remaques :</label></div>
                            <div class="col-lg-10"><input type="text" name="remarques" required=""></div>
                        </div>
                        <input class="btn btn-success btn-lg" type="submit" value="Ajouter" name="btnsave" >
                    </fieldset>
                </form>
            </div>
        </div>
    </body>
</html>
