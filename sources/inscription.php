<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require './dao.php';
if (isset($_REQUEST["btnsave"])) {
    $rue = str_replace(' ', '+', $_REQUEST["rue"]);
    $curl = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $_REQUEST["numero"] . ",+" . $rue . ",+" . $_REQUEST["codepostal"] . ",+" . $_REQUEST["pays"] . "&key=AIzaSyDdezmXoTVAy5mzdrq1qWmpErIj9kuCkH4";
    $getCoordonée = curl_init($curl);
    curl_setopt($getCoordonée, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($getCoordonée, CURLOPT_SSL_VERIFYPEER, false);
    $info = json_decode(curl_exec($getCoordonée), true);
    $lat = $info["results"][0]["geometry"]["location"]["lat"];
    $lng = $info["results"][0]["geometry"]["location"]["lng"];
    if ($_REQUEST["pwd"] == $_REQUEST["pwd2"]) {
        inscriptionUtilisateur($_REQUEST["nom"], $_REQUEST["prenom"], sha1($_REQUEST["pwd2"]), $_REQUEST["date"], $_REQUEST["desc"]
                , $_REQUEST["pays"], $_REQUEST["rue"], $_REQUEST["numero"], $_REQUEST["codepostal"], $lat, $lng, $_REQUEST["mail"]);
        header('Location: index.php');
    } else {
        echo"Les deux mots de passe ne correspondent pas";
    }
}
?> 
<html>
    <head>
        <meta charset="UTF-8">
        <link href="startbootstrap-freelancer-gh-pages/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="startbootstrap-freelancer-gh-pages/css/freelancer.min.css" rel="stylesheet" type="text/css">
        <link href="startbootstrap-freelancer-gh-pages/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <title>Inscription</title>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-custom" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="index.php">Buddy-Sitter</a>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="connexion.php">Connexion</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="row">
            <div class="col-lg-10 col-lg-offset-2">
                <form action="inscription.php" method="POST">
                    <div class="row">
                        <div class="col-lg-2"><label>Nom :</label></div>
                        <div class="col-lg-10"><input type="text" name="nom" required="" value="<?php if (isset($_REQUEST['nom'])) echo $_REQUEST['nom']; ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2"><label>Prénom :</label></div>
                        <div class="col-lg-10"><input type="text" name="prenom" required="" value="<?php if (isset($_REQUEST['prenom'])) echo $_REQUEST['prenom']; ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2"><label>Email :</label></div>
                        <div class="col-lg-10"><input placeholder="xyz@xyz.xx" type="email" name="mail" required="" value="<?php if (isset($_REQUEST['mail'])) echo $_REQUEST['mail']; ?>"></div>
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
                        <div class="col-lg-10"><input type="date" name="date" required="" value="<?php isset($_REQUEST["date"]) ? $_REQUEST["date"] : ""; ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2"><label>Decrivez-vous :</label></div>
                        <div class="col-lg-10"><textarea  name="desc" rows="5" cols="50" value="<?php isset($_REQUEST["desc"]) ? $_REQUEST["desc"] : ""; ?>"></textarea></div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><label>Pays :</label></div>
                        <div class="col-lg-10"><input placeholder="Ex:Suisse" type="text" name="pays" required="" value="<?php isset($_REQUEST["pays"]) ? $_REQUEST["pays"] : ""; ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2"><label>Rue :</label></div>
                        <div class="col-lg-10"><input size="50" placeholder="Ex: Avenue des Avionnettes" type="text" name="rue" required="" value="<?php isset($_REQUEST["rue"]) ? $_REQUEST["rue"] : ""; ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2"><label>Numéro de rue :</label></div>
                        <div class="col-lg-10"><input  type="text" name="numero" required="" value="<?php isset($_REQUEST["numero"]) ? $_REQUEST["numero"] : ""; ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2"><label>Code postal :</label></div>
                        <div class="col-lg-10"><input type="text" name="codepostal" required="" value="<?php isset($_REQUEST["codepostal"]) ? $_REQUEST["codepostal"] : ""; ?>"></div>
                    </div>
                    <input class="btn btn-success btn-lg" type="submit" value="S'enregistrer" name="btnsave" >
                </form>
            </div>
        </div>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCAEkv33ltVdDj2PWlspis4tGUNOsScego&callback=myMap"></script>
    </body>
</html>
