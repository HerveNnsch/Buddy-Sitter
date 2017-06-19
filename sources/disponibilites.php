<!DOCTYPE html>
<!--
Auteur: Hervé Neuenschwander
But: permet à un utilisateur d'insérer ses disponibilités
-->
<?php
session_start();
require './dao.php';
require './phptohtml.php';

if (!isset($_SESSION["id"])) {
    header('Location: index.php');
    exit();
}
$erreur = "";
$races = recupererEspeces();
$horaires = recupererHoraires();
$disponibilites = recupererDisponibilites($_SESSION["id"]);
$racesGardables = recupererEspeceGardable($_SESSION["id"]);

if (isset($_REQUEST["btnsave"])) {
    deleteDisponibilites($_SESSION["id"]);
    supprimerChoixRaces($_SESSION["id"]);
    if (isset($_POST["espece"]) and isset($_POST["disponible"])) {
        foreach ($_POST["disponible"] as $dispo) {
            insererDisponibilites($dispo, $_SESSION["id"]);
        }
        foreach ($_POST["espece"] as $espece) {
            insererChoixRace($espece, $_SESSION["id"]);
        }
        header('Location: profil.php');
        exit();
    } else if (!(isset($_POST["espece"])) and ! (isset($_POST["disponible"]))) {
        header('Location: profil.php');
        exit();
    } else {
        if (!isset($_POST["espece"])) {
            $erreur = "Vous n'avez sélectionner aucune espèce";
        }
        if (!isset($_POST["disponible"])) {
            $erreur = "Vous n'avez sélectionner aucun moment de la semaine";
        }
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="startbootstrap-freelancer-gh-pages/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="startbootstrap-freelancer-gh-pages/css/freelancer.min.css" rel="stylesheet" type="text/css">
        <link href="startbootstrap-freelancer-gh-pages/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="jquery-3.1.0.js"></script>
        <title>Disponibilités</title>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-custom" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="index.php">Buddy-Sitter</a>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="profil.php">Profil</a></li>
                    <li><a href='ajoutanimal.php'>Ajouter un animal</a></li>
                    <li class="active"><a href='disponibilites.php'>Disponibilités</a></li>
                    <li><a href="rechercher.php">Rechercher un gardien</a></li>
                    <li><a href='deconnexion.php'>Déconnexion</a></li>
                </ul>

            </div>
        </nav>
        <div class="row">
            <div class="intro-text col-lg-12 text-center">
                <h1 class="name">Disponibilités</h1>
            </div>
            <div class="col-lg-10 col-lg-offset-2">
                <form action="disponibilites.php" method="POST">
                    <fieldset>
                        <div class="row">
                            <div class="col-lg-12"><label style="color: red"><?= $erreur ?></label></div>
                        </div>
                        <legend>Vos disponibilités en tant que gardien</legend>
                        <?php afficherDisponibilites($disponibilites, $horaires, true); ?>
                        <br/><?php afficherEspeces($races, $racesGardables); ?>
                    </fieldset>
                    <input class="btn btn-success btn-lg" type="submit" value="Enregistrer" name="btnsave" >
                </form>
            </div>
        </div>
    </body>
</html>
