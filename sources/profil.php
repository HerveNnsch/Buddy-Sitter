<!DOCTYPE html>
<!--
Auteur: Hervé Neuenschwander
But: Affiche le profil d'un utilisateur
-->
<?php
session_start();
require './dao.php';
require './phptohtml.php';

if(!isset($_SESSION["id"])){
     header('Location:index.php');
     exit();
}

$utilisateur = recupererUtilisateur($_SESSION["id"]);
$adresse = recupererAdresse($utilisateur[0]["idAdresse"]);
$especes = recupererEspeces();
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
        
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href='ajoutanimal.php'>Ajouter un animal</a></li>
                        <li><a href='disponibilites.php'>Disponibilités</a></li>
                        <li><a href="rechercher.php">Rechercher</a></li>
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
                <?php afficherUtilisateur($utilisateur) ?>
                <?php afficherAdresse($adresse) ?>
                <br/>
                <h2>Mes animaux</h2>
                <?php afficherAnimaux($animaux, $especes) ?>
                <h2>Mes disponibilités</h2>
                <?php afficherDisponibilites($disponibilites, recupererHoraires(),false);?>
                <a href="disponibilites.php">Modifier</a>
            </div>
        </div>
    </body>
</html>
