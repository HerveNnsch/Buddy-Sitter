<!DOCTYPE html>
<!--
Auteur: Hervé Neuenschwander
But: Affiche les gardien disponibles pour un gardiennage
Date: 15.06.2017

-------------------
Version 1.0 Date 15.06.2017
La page affiche les gardien disponibles et affiche une carte avec des marqueur 
ou habitent des gardiens

-->
<?php
session_start();
require './dao.php';
require './phptohtml.php';
//si on accède à la page sans être connecté on est redirigé
if (!isset($_SESSION["id"])) {
    header('Location:index.php');
    exit();
}

if (isset($_REQUEST["disponible"])) {
    $animal = recupererAnimal($_REQUEST["animal"]);
    $adresse = recupererAdresseDeUtilisateur($_SESSION["id"]);
    $resultats = rechercherGardien($_REQUEST["disponible"], $animal[0]["idEspece"], $adresse[0]["Lat"], $adresse[0]["Lng"], $_REQUEST["distance"],$_SESSION["id"]);
    //si aucun gardien n'a été trouvé on redirige vers la page de recherche avec l'erreur n° 2
    if (count($resultats) < 1) {
        header('Location:rechercher.php?erreur=2');
        exit();
    }
    //si aucun moment de la semaine n'a été coché on redirige vers recherche avec l'erreur n°1
} else {
    header('Location:rechercher.php?erreur=1');
    exit();
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="startbootstrap-freelancer-gh-pages/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="startbootstrap-freelancer-gh-pages/css/freelancer.min.css" rel="stylesheet" type="text/css">
        <link href="startbootstrap-freelancer-gh-pages/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <title>Résultats</title>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-custom" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="index.php">Buddy-Sitter</a>

                <ul class="nav navbar-nav navbar-right">
                     <li><a href="index.php">Accueil</a></li>
                    <li><a href="profil.php">Profil</a></li>
                    <li><a href='ajoutanimal.php'>Ajouter un animal</a></li>
                    <li><a href='disponibilites.php'>Disponibilités</a></li>
                    <li><a href="rechercher.php">Rechercher un gardien</a></li>
                    <li><a href='deconnexion.php'>Déconnexion</a></li>
                </ul>

            </div>
        </nav>
        <div class="row">
            <div class="intro-text col-lg-12 text-center">
                <h1 class="name">Résultats</h1>
                <div class="col-lg-4" id="googleMap" style="width:40%;height:400px;margin-left: 25px;"></div>
                <p style="color: #18BC9C">Cliquez sur un marqueur pour savoir qui habite la !</p>
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCAEkv33ltVdDj2PWlspis4tGUNOsScego&callback=myMap"></script>
                <script>
                    var map;
                    function myMap(lat, lng) {
                        var mapProp = {
                            center: new google.maps.LatLng(lat, lng),
                            zoom: 8
                        };
                        map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
                    }
                    ;

                    function addMarker(lat, lng, nom) {
                        var myCenter = new google.maps.LatLng(lat, lng);
                        var marker = new google.maps.Marker({position: myCenter});
                        marker.setMap(map);
                        google.maps.event.addListener(marker, 'click', function () {
                            var infowindow = new google.maps.InfoWindow({
                                content: nom
                            });
                            infowindow.open(map, marker);
                        });
                    }
                    myMap(<?php echo $resultats[0]["lat"] ?>,<?php echo $resultats[0]["lng"] ?>);
                </script>
                <div class="col-lg-5 col-lg-offset-1 text-left">
                    <?php
                    foreach ($resultats as $gardien):
                        $infosGardien = recupererUtilisateur($gardien["idUtilisateur"]);
                        $adresseGardien = recupererAdresseDeUtilisateur($infosGardien[0]["idAdresse"]);
                        afficherGardien($infosGardien, $adresseGardien);
                        ?>
                        <script>addMarker(<?php echo $gardien["lat"] ?>,<?php echo $gardien["lng"] ?>, "<?= $infosGardien[0]["Nom"] ?>");</script>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </body>
</html>