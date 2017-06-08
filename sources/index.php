<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="startbootstrap-freelancer-gh-pages/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="startbootstrap-freelancer-gh-pages/css/freelancer.min.css" rel="stylesheet" type="text/css">
        <link href="startbootstrap-freelancer-gh-pages/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <title>Accueil</title>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-custom" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="index.php">Buddy-Sitter</a>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        
                        <?php
                        if (isset($_SESSION["id"])) {
                            echo "<li><a href='profil.php'>Profil</a></li>";
                            echo "<li><a href='deconnexion.php'>Déconnexion</a></li>";
                        }else{
                            echo "<li><a href='connexion.php'>Connexion</a></li>";
                            echo "<li><a href='inscription.php'>Inscription</a></li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Bienvenue</h2>
                    <hr class="star-primary">
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">Bienvenue sur le site BuddySitter qui permet de garder vos animaux de compagnies !</div>
                </div>
            </div>
        </div>
    </body>
</html>
