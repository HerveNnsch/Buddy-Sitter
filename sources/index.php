<!DOCTYPE html>
<!--
Auteur: Hervé Neuenschwander
But: Page d'accueil du site
Date: 19.06.2017
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
                <div>
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Barre de navigation-->
                        <?php if (isset($_SESSION["id"])): ?>
                            <li class="active"><a href="index.php">Accueil</a></li>
                            <li><a href="profil.php">Profil</a></li>
                            <li><a href='ajoutanimal.php'>Ajouter un animal</a></li>
                            <li><a href='disponibilites.php'>Disponibilités</a></li>
                            <li><a href="rechercher.php">Rechercher un gardien</a></li>
                            <li><a href='deconnexion.php'>Déconnexion</a></li>
                        <?php else: ?>
                            <li class="active"><a href="index.php">Accueil</a></li>
                            <li><a href='connexion.php'>Connexion</a></li>
                            <li><a href='inscription.php'>Inscription</a></li>
                        <?php endif; ?>
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
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Ce site vous permet de faire garder vos animaux de compagnie ou de garder des animaux d'autres personnes.</p>
                    <p>En vous inscrivant sur ce site vous pourrez inscrire vos animaux et une après cela 
                        vous pourrez rechercher un gardien pour garder vos animaux.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <img src="ressources/animauxcompagnies.jpg">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Faire garder vos animaux</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Une fois inscrit vous aurez accès à votre page personnel sur laquelle vous pourrez voir vos informations
                        personnelles et les modifier. Vous pourrez aussi inscrire vos animaux de compagnies.</p>
                    <p>Après avoir inscrit vos animaux vous pourrez rechercher un gardien pour garder vos animaux. 
                        Il vous suffira de choisir votre animal à garder, quand vous voulez le faire garder, et la distance maximale
                        entre votre domicile et celui du gardien. 
                        Ça y est! Il ne vous reste plus qu'a contacter un gardien par Email.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Devenir gardien</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Une fois inscrit et connecté vous pouvez devenir gardien. Pour cela il vous suffit de dire quand et quelle type d'animal vous
                        voulez garder.</p>
                    <p>Pour ajouter ou modifier vos disponibilités en tant que gardien il vous faut soit aller sur votre profil et cliquer 
                        sur le lien "Modifier" sous le tableau des disponibilités, soit cliquer sur le lien en haut 
                        écrit "Disponibilités".</p>
                    <p>Vous pourrez ensuite cocher les moments de la semaine ou vous êtes libre et les espèces d'animaux que vous êtes d'accord
                        de garder. </p>
                    <p>Ça y est! Vous êtes gardien.</p>
                </div>
            </div>
        </div>
    </body>
</html>
