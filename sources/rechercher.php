<!DOCTYPE html>
<!--
Auteur: Hervé Neuenschwander
But: Permet de faire la recherche pour garder un animal
-->
<?php
session_start();
require './dao.php';
require './phptohtml.php';

if (!isset($_SESSION["id"])) {
    header('Location:index.php');
    exit();
}
$erreur = "";
if (isset($_GET["erreur"])) {
    if ($_GET["erreur"] == 1) {
        $erreur = "Veuillez rentrer un moment de la semaine";
    }
    if ($_GET["erreur"] == 2) {
        $erreur = "Personne ne correspond à votre recherche";
    }
}

$animaux = recupererAnimauxDepuisUtilisateur($_SESSION["id"]);
$utilisateur = recupererUtilisateur($_SESSION["id"]);
$horaires = recupererHoraires();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="startbootstrap-freelancer-gh-pages/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="startbootstrap-freelancer-gh-pages/css/freelancer.min.css" rel="stylesheet" type="text/css">
        <link href="startbootstrap-freelancer-gh-pages/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <title>Rechercher</title>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-custom" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="index.php">Buddy-Sitter</a>

                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="profil.php">Profil</a></li>
                    <li><a href='ajoutanimal.php'>Ajouter un animal</a></li>
                    <li><a href='disponibilites.php'>Disponibilités</a></li>
                    <li class="active"><a href="rechercher.php">Rechercher un gardien</a></li>
                    <li><a href='deconnexion.php'>Déconnexion</a></li>
                </ul>

            </div>
        </nav>
        <div class="row">
            <div class="col-lg-10 col-lg-offset-2">
                <form action="resultats.php" method="POST">
                    <fieldset>
                        <legend>Rechercher un gardien</legend>
                        <div class="row">
                            <div class="col-lg-12"><label style="color: red"><?= $erreur ?></label></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2"><label>Votre animal :</label></div>
                            <div class="col-lg-10"><?php afficherAnimauxSelect($animaux); ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2"><label>Nom propriétaire:</label></div>
                            <div class="col-lg-10"><?= $utilisateur[0]["Nom"] ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2"><label>Moments à garder :</label></div>
                            <div class="col-lg-10"><?php afficherDisponibilites([], $horaires, true) ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2"><label>Distance maximum (en km):</label></div>
                            <div class="col-lg-10"><input type="number" name="distance" required="" min="1" max="200" value="20"></div>
                        </div>
                        <input class="btn btn-success btn-lg" type="submit" value="Rechercher" name="btnsave" >
                    </fieldset>
                </form>
            </div>
        </div>
    </body>
</html>
