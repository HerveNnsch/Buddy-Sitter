<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require './dao.php';
$utilisateur=  recupererUtilisateur($_GET["id"]);
if(isset($_REQUEST["btnsave"])){
    modifierUtilisateur($_REQUEST["nom"], $_REQUEST["prenom"], sha1($_REQUEST["pwd2"]), $_REQUEST["date"], $_REQUEST["desc"], $_GET["id"], $_REQUEST["mail"]);
    header('Location: profil.php');
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="startbootstrap-freelancer-gh-pages/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="startbootstrap-freelancer-gh-pages/css/freelancer.min.css" rel="stylesheet" type="text/css">
        <link href="startbootstrap-freelancer-gh-pages/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <title>Modifier vos informations</title>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-custom" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="index.php">Buddy-Sitter</a>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href='profil.php'>Profil</a></li>
                        <li><a href="deconnexion.php">Déconnexion</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="row">
            <div class="col-lg-10 col-lg-offset-2">
                <form action="modifierinformations.php?id=<?= $_GET["id"]?>" method="POST">
                    <fieldset>
                        <legend>Modification d'informations</legend>
                        <div class="row">
                            <div class="col-lg-2"><label>Nom :</label></div>
                            <div class="col-lg-10"><input type="text" name="nom" required="" value="<?= $utilisateur[0]["Nom"] ?>"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2"><label>Prénom :</label></div>
                            <div class="col-lg-10"><input type="text" name="prenom" required="" value="<?= $utilisateur[0]["Prenom"] ?>"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2"><label>Email :</label></div>
                            <div class="col-lg-10"><input placeholder="xyz@xyz.xx" type="email" name="mail" required="" value="<?= $utilisateur[0]["Email"] ?>"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2"><label>Mot de passe :</label></div>
                            <div class="col-lg-10"><input type="password" name="pwd" required=""></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2"><label>Confimer le mot de passe :</label></div>
                            <div class="col-lg-10"><input type="password" name="pwd2" required=""></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2"><label>Date de naissance :</label></div>
                            <div class="col-lg-10"><input type="date" name="date" required="" value="<?= $utilisateur[0]["DateNaissance"] ?>"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2"><label>Decrivez-vous :</label></div>
                            <div class="col-lg-10"><textarea  name="desc" rows="5" cols="50"><?= $utilisateur[0]["Description"] ?></textarea></div>
                        </div>
                        <input class="btn btn-success btn-lg" type="submit" value="Enregistrer les modifications" name="btnsave" >
                    </fieldset>
                </form>
            </div>
        </div>
    </body>
</html>
