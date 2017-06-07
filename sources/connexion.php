<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
require './dao.php';
if (isset($_REQUEST["btnsave"])) {
    $utilisateur = connexion(sha1($_REQUEST["pwd"]), $_REQUEST["nom"]);
    if (count($utilisateur) > 0) {
        $_SESSION["id"] = $utilisateur[0]["idUtilisateur"];
        header('Location: index.php');
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="startbootstrap-freelancer-gh-pages/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="startbootstrap-freelancer-gh-pages/css/freelancer.min.css" rel="stylesheet" type="text/css">
        <link href="startbootstrap-freelancer-gh-pages/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <title>Connexion</title>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-custom" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="index.php">Buddy-Sitter</a>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="inscription.php">Inscription</a></li>
                        <?php
                        if (isset($_SESSION["id"])) {
                            echo "<li'><a href='profil.php'>Profil</a></li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="row">
            <div class="col-lg-10 col-lg-offset-2">
                <div class="col-lg-12 ">
                    <h2>Connexion</h2>
                </div>
                <form action="connexion.php" method="POST">
                    <div class="row">
                        <div class="col-lg-2">
                            <label>Nom :</label></div>
                        <div class="col-lg-10"><input type="text" name="nom" required=""></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <label>Mot de passe :</label></div>
                        <div class="col-lg-10"><input type="password" name="pwd" required=""></div>
                    </div>
                    <input class="btn btn-success btn-lg" type="submit" value="Se connecter" name="btnsave" >
                </form>
            </div>
        </div>
    </body>
</html>
