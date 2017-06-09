<!DOCTYPE html>
<!--
Auteur: Hervé Neuenschwander
But: permet à un utilisateur d'insérer ses disponibilités
-->
<?php
session_start();
require './dao.php';
require './phptohtml.php';
$races = recupererRaces();
$horaires=  recupererHoraires();
$disponibilites = recupererDisponibilités($_SESSION["id"]);
$racesGardables=  recupererEspeceGardable($_SESSION["id"]);

if (!isset($_SESSION["id"])) {
    header('Location: index.php');
}

if (isset($_REQUEST["btnsave"])) {
    deleteDisponibilites($_SESSION["id"]);
    foreach ($_POST["disponible"] as $dispo) {
        insererDisponibilites($dispo, $_SESSION["id"]);
    }
    supprimerChoixRaces($_SESSION["id"]);
    foreach ($_POST["espece"] as $espece) {
        insererChoixRace($espece, $_SESSION["id"]);
    }
    header('Location: profil.php');
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="startbootstrap-freelancer-gh-pages/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="startbootstrap-freelancer-gh-pages/css/freelancer.min.css" rel="stylesheet" type="text/css">
        <link href="startbootstrap-freelancer-gh-pages/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <title>Disponibilités</title>
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
                <h1 class="name">Disponibilités</h1>
            </div>
            <div class="col-lg-10 col-lg-offset-2">
                <form action="disponibilites.php" method="POST">
                    <fieldset>
                        <legend>Ajouter des disponibilités</legend>
                        <?php
                        
                        afficherDisponibilites($disponibilites, $horaires,true);
                        afficherEspeces($races,$racesGardables);
                        ?>
                    </fieldset>
                    <input class="btn btn-success btn-lg" type="submit" value="Enregistrer" name="btnsave" >
                </form>
            </div>
        </div>
    </body>
</html>
