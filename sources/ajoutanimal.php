<!DOCTYPE html>
<!--
Auteur: Hervé Neuenschwander
But: permet d'ajouter un animal
Date: 19.06.2017
-->
<?php
session_start();
require './dao.php';

if (!isset($_SESSION["id"])) {
    header('Location:index.php');
    exit();
}

$lesraces = recupererEspeces ();
if (isset($_REQUEST["btnsave"])) {
    $animal = inscriptionAnimal($_REQUEST["races"], $_REQUEST["nom"], $_REQUEST["date"], $_REQUEST["remarques"], $_SESSION["id"]);
    header('Location:profil.php');
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
                
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php">Accueil</a></li>
                    <li><a href="profil.php">Profil</a></li>
                    <li class="active"><a href='ajoutanimal.php'>Ajouter un animal</a></li>
                    <li><a href='disponibilites.php'>Disponibilités</a></li>
                    <li><a href="rechercher.php">Rechercher un gardien</a></li>
                    <li><a href='deconnexion.php'>Déconnexion</a></li>
                    </ul>
               
            </div>
        </nav>
        <div class="row">
            <div class="col-lg-10 col-lg-offset-2">
                <form action="ajoutanimal.php" method="POST">
                    <fieldset>
                        <legend>Ajout d'un animal</legend>
                        <div class='row'>
                            <div class="col-lg-2"><label>Espèce :</label></div>
                            <div class="col-lg-10">
                                <select name="races">
                                    <?php
//affiche la liste à choix pour les races
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
                            <div class="col-lg-10"><textarea  name="remarques" rows="5" cols="50"></textarea></div>
                        </div>
                        <input class="btn btn-success btn-lg" type="submit" value="Ajouter" name="btnsave" >
                    </fieldset>
                </form>
            </div>
        </div>
    </body>
</html>
