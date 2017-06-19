<!DOCTYPE html>
<!--
Auteur: Hervé Neuenschwander
But: Affiche le profil d'un utilisateur
Date: 15.06.2017
-------------------
Version 1.0 Date: 15.06.2017


-->
<?php
session_start();
require './dao.php';
require './phptohtml.php';
//redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION["id"])) {
    header('Location:index.php');
    exit();
}

//récupératin des informations nécessaires pour l'affichage de la page
$utilisateur = recupererUtilisateur($_SESSION["id"]);
$adresse = recupererAdresse($utilisateur[0]["idAdresse"]);
$especes = recupererEspeces();
$animaux = recupererAnimauxDepuisUtilisateur($_SESSION["id"]);
$disponibilites = recupererDisponibilites($_SESSION["id"]);
$eGardable = recupererEspeceGardable($_SESSION["id"]);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="startbootstrap-freelancer-gh-pages/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="startbootstrap-freelancer-gh-pages/css/freelancer.min.css" rel="stylesheet" type="text/css">
        <link href="startbootstrap-freelancer-gh-pages/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <title>Profil</title>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-custom" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="index.php">Buddy-Sitter</a>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php">Accueil</a></li>
                    <li class="active"><a href="profil.php">Profil</a></li>
                    <li><a href='ajoutanimal.php'>Ajouter un animal</a></li>
                    <li><a href='disponibilites.php'>Disponibilités</a></li>
                    <li><a href="rechercher.php">Rechercher un gardien</a></li>
                    <li><a href='deconnexion.php'>Déconnexion</a></li>
                </ul>
            </div>
        </nav>
        <div class="row">
            <div class="intro-text col-lg-12 text-center">
                <h1 class="name">Profil</h1>
            </div>
            <div class="col-lg-10 col-lg-offset-2">
                <h2>Informations personnels</h2>
                <!-- Affichage des informations personnelles et de l'adresse -->
                <?php afficherUtilisateur($utilisateur) ?>
                <?php afficherAdresse($adresse) ?>
                <br/>
                <h2>Mes animaux</h2>
                <!-- Affichage des animaux -->
                <?php afficherAnimaux($animaux, $especes) ?>
                <h2>Mes disponibilités</h2>
                <!-- Affichage des disponibilités -->
                <?php afficherDisponibilites($disponibilites, recupererHoraires(), false); ?>
                Vous gardez les :
                <?php
                foreach ($eGardable as $idEspece) {
                    echo $especes[$idEspece["idEspece"] - 1]["NomEspece"]." ";
                }
                ?>
                <br/>
                <a href="disponibilites.php">Modifier</a>
            </div>
        </div>
    </body>
</html>
