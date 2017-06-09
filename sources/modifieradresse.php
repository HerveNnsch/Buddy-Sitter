<!DOCTYPE html>
<!--
Auteur: Hervé Neuenschwander
But: Permet de modifier l'adresse d'un utilisateur
-->
<?php
require './dao.php';
$adresse = recupererAdresse($_GET["idAdresse"]);
if(isset($_REQUEST["btnsave"])){
    $rue = str_replace(' ', '+', $_REQUEST["rue"]);
    $curl = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $_REQUEST["numero"] . ",+" . $rue . ",+" . $_REQUEST["codepostal"] . ",+" . $_REQUEST["pays"] . "&key=AIzaSyDdezmXoTVAy5mzdrq1qWmpErIj9kuCkH4";
    $getCoordonée = curl_init($curl);
    curl_setopt($getCoordonée, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($getCoordonée, CURLOPT_SSL_VERIFYPEER, false);
    $info = json_decode(curl_exec($getCoordonée), true);
    $lat = $info["results"][0]["geometry"]["location"]["lat"];
    $lng = $info["results"][0]["geometry"]["location"]["lng"];
    modifierAdresse($_REQUEST["numero"], $_REQUEST["rue"], $_REQUEST["codepostal"], $_REQUEST["pays"], $lat, $lng, $_GET["idAdresse"]);
    header('Location: profil.php');
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="startbootstrap-freelancer-gh-pages/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="startbootstrap-freelancer-gh-pages/css/freelancer.min.css" rel="stylesheet" type="text/css">
        <link href="startbootstrap-freelancer-gh-pages/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <title>Modifier votre adresse</title>
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
                <form action="modifieradresse.php?idAdresse=<?=$_GET["idAdresse"]?>" method="POST">
                    <fieldset>
                        <legend>Modification d'adresse</legend>
                        <div class="row">
                            <div class="col-lg-2"><label>Pays :</label></div>
                            <div class="col-lg-10"><input type="text" name="pays" required="" value="<?= $adresse[0]["Pays"] ?>"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2"><label>Rue :</label></div>
                            <div class="col-lg-10"><input size="50" type="text" name="rue" required="" value="<?= $adresse[0]["NomRue"] ?>"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2"><label>Numéro de rue :</label></div>
                            <div class="col-lg-10"><input  type="text" name="numero" required="" value="<?= $adresse[0]["Numero"] ?>"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2"><label>Code postal :</label></div>
                            <div class="col-lg-10"><input type="text" name="codepostal" required="" value="<?= $adresse[0]["CodePostal"] ?>"></div>
                        </div>
                        <input class="btn btn-success btn-lg" type="submit" value="Enregistrer les modifications" name="btnsave" >
                    </fieldset>
                </form>
            </div>
        </div>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCAEkv33ltVdDj2PWlspis4tGUNOsScego&callback=myMap"></script>
    </body>
</html>
