<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
require './dao.php';
require './phptohtml.php';
$utilisateur = recupererUtilisateur($_SESSION["id"]);
$adresse = recupererAdresse($utilisateur[0]["idAdresse"]);
$especes = recupererRaces();
$animaux = recupererAnimauxDepuisUtilisateur($_SESSION["id"]);
$disponibilites = recupererDisponibilités($_SESSION["id"]);
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
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href='ajoutanimal.php'>Ajouter un animal</a></li>
                        <li><a href='disponibilites.php'>Disponibilités</a></li>
                        <li><a href='deconnexion.php'>Déconnexion</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="row">
            <div class="intro-text col-lg-12 text-center">
                <h1 class="name">Profil</h1>
            </div>
            <div class="col-lg-10 col-lg-offset-2">
                <h2>Informations personnels</h2>
                <?php afficherUtilisateur($utilisateur) ?>
                <?php afficherAdresse($adresse) ?>
                <br/>
                <h2>Mes animaux</h2>
                <?php afficherAnimaux($animaux, $especes) ?>
                <?php
                //afficherDisponibilites($disponibilites);
                afficherDisponibilitesDeux($disponibilites, recupererHoraires(),false);
                ?>
            </div>
        </div>
    </body>
</html>
