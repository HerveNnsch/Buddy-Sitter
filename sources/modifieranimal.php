<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require './dao.php';
$animal = recupererAnimal($_GET["id"]);
$lesraces = recupererRaces();

if(isset($_REQUEST["btnsave"])){
    modifierAnimal($_REQUEST["nom"], $_REQUEST["date"], $_REQUEST["remarques"], $_REQUEST["race"], $_GET["id"]);
    header('Location:profil.php');
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="startbootstrap-freelancer-gh-pages/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="startbootstrap-freelancer-gh-pages/css/freelancer.min.css" rel="stylesheet" type="text/css">
        <link href="startbootstrap-freelancer-gh-pages/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <title>Modifier <?= $animal[0]["NomAnimal"] ?></title>
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
                <form action="modifieranimal.php?id=<?= $_GET["id"] ?>" method="POST">
                    <fieldset>
                        <legend>Modification d'informations</legend>
                        <div class='row'>
                            <div class="col-lg-2"><label>Espèce :</label></div>
                            <div class="col-lg-10"><select name="race">
                                    <?php
                                    foreach ($lesraces as $race) {
                                        $selected="";
                                        if($race["idEspece"]==$animal[0]["idEspece"]){
                                            $selected="selected";
                                        }
                                        echo "<option value=" . $race["idEspece"] . " ".$selected.">" . $race["NomEspece"] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2"><label>Nom :</label></div>
                            <div class="col-lg-10"><input type="text" name="nom" required="" value="<?= $animal[0]["NomAnimal"] ?>"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2"><label>Date de naissance :</label></div>
                            <div class="col-lg-10"><input type="date" name="date" required="" value="<?= $animal[0]["DateNaissanceAnimal"] ?>"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2"><label>Remarques :</label></div>
                            <div class="col-lg-10"><textarea  name="remarques" rows="5" cols="50"><?= $animal[0]["Remarques"] ?></textarea></div>
                        </div>
                        <input class="btn btn-success btn-lg" type="submit" value="Enregistrer les modifications" name="btnsave" >
                    </fieldset>
                </form>
            </div>
        </div>
    </body>
</html>
