<?php
/*
 * Auteur: Hervé Neuenschwander
 * But: regroupe des fonctions pour afficher des informations en html depuis du PHP
 * Date: 13.06.2017
 * -------------------------------
 * Version 0.9 Date 14.06.2017
 * Ajout de la fonction afficherGardien
 * 
 * Version 0.8 Date 13.06.2017
 * Six fonctions qui permettent d'afficher des infos
 * afficherutilisateur: Affiche les infos d'un utilisateur
 * afficherAdresse: Affiche l'adresse
 * afficherAnimaux: Affiche un tableau des animaux d'un utilisateur
 * afficherEspeces: Affiche les especes dans des chekbox
 * afficherAnimauxSelect: Affiche les animaux d'un utilisateur dans un select
 * afficherDisponibilites: Affiche un tableau avec des chekbox pour les disponibilités
 */

/**
 * Affiche les infos d'un utilisateur
 * @param array $infos informations de l'utilisateur
 */
function afficherUtilisateur($infos) {
    ?>
    <fieldset style="width: 40%; float: left;">
        <legend>Informations personnelles</legend>
        <label>Nom: <?= $infos[0]["Nom"] ?></label><br/>
        <label>Prénom: <?= $infos[0]["Prenom"] ?></label><br/>
        <label>Date de naissance: <?= $infos[0]["DateNaissance"] ?></label><br/>
        <label>Email: <?= $infos[0]["Email"] ?></label><br/>
        <label>Description: <?= $infos[0]["Description"] ?></label><br/>
        <a href='modifierinformations.php'>Modifier</a>
    </fieldset>
    <?php
}

/**
 * Affiche l'adresse d'un utilisateur
 * @param array $infos informations de l'adresse
 */
function afficherAdresse($infos) {
    ?>
    <fieldset style="width: 40%; float: rigth;">
        <legend>Adresse</legend>
        <label>Rue: <?= $infos[0]["NomRue"] ?></label><br/>
        <label>Numéro: <?= $infos[0]["Numero"] ?></label><br/>
        <label>CodePostal: <?= $infos[0]["CodePostal"] ?></label><br/>
        <label>Pays: <?= $infos[0]["Pays"] ?></label><br/>
        <a href='modifieradresse.php?idAdresse=<?= $infos[0]["idAdresse"] ?>'>Modifier</a>
    </fieldset>
    <?php
}

/**
 * Affiche les animaux d'un utilisateur
 * @param array $infos informations des aniamux
 * @param array $especes informations des éspèces
 */
function afficherAnimaux($infos, $especes) {
    ?>
    <table class="table-responsive table-bordered" style="width: 70%;">
        <tr>
            <th>Nom</th>
            <th>Espèce</th>
            <th>Date de naissance</th>
            <th>Remarques</th>
            <th>Modifier</th>
        </tr>
    <?php foreach ($infos as $animal) : ?>
            <tr>
                <td><?= $animal["NomAnimal"] ?></td>
                <td><?= $especes[$animal["idEspece"] - 1]["NomEspece"] ?></td>
                <td><?= $animal["DateNaissanceAnimal"] ?></td>
                <td><?= $animal["Remarques"] ?></td>
                <td><a href='modifieranimal.php?id=<?= $animal["idAnimal"] ?>'>Modifier</a></td>
            </tr>
    <?php endforeach; ?>
    </table>
    <?php
}

/**
 * Affiche toutes les espèces dans des chekbox
 * @param array $infos disponibilités d'un gardien pour garder les espèces
 * @param array $especes toutes les informations de la table especes
 */
function afficherEspeces($infos, $especes) {
    $gardable = [];
    foreach ($especes as $id) {
        $gardable[] = $id["idEspece"];
    }
    ?>
    <label>Espèces:</label><br/>
    <?php foreach ($infos as $animal) : ?>
        <input type='checkbox' name='espece[]' value='<?= $animal["idEspece"] ?>'<?php if (in_array($animal["idEspece"], $gardable)) {
            echo "checked";
        } ?>><?= $animal["NomEspece"] ?><br/>
        <?php
    endforeach;
}

/**
 * Affiche un select avec les animaux d'un utilisateur
 * @param array $infos tablaeu des animaux d'un utilisateur
 */
function afficherAnimauxSelect($infos) {
    ?>
    <select name="animal"><?php
    foreach ($infos as $animal) {
        echo "<option value=" . $animal["idAnimal"] . ">" . $animal["NomAnimal"] . "</option>";
    }
    ?></select>
    <?php
}

/**
 * Affiche le tableau des disponibilités
 * @param array $disponible les disponibilités d'un utilisateur, vide si c'est la première fois
 * @param array $horaires toutes les horaires
 * @param bool $modif les chekbox sont elles activée
 */
function afficherDisponibilites($disponible, $horaires, $modif) {
    $idHoraire = [];
    foreach ($disponible as $id) {
        $idHoraire[] = $id["idHoraire"];
    }
    ?>
    <table border='1' id="dispo">
        <tr>
            <td>Lundi</td>
            <td>Mardi</td>
            <td>Mercredi</td>
            <td>Jeudi</td>
            <td>Vendredi</td>
            <td>Samedi</td>
            <td>Dimanche</td>
        </tr>
        <tr>
            <?php for ($i = 0; $i < count($horaires); $i+=3): ?>
                <td>
        <?php for ($j = $i; $j < $i + 3; $j++): ?>
                        <input class="dispos" type="checkbox" name="disponible[]" onclick="<?php if (!$modif) {
                echo "return false";
            } ?>" value="<?= $horaires[$j]["idHoraire"] ?>" <?php if (in_array($horaires[$j]["idHoraire"], $idHoraire)) {
                echo"checked";
            } ?> > <?= $horaires[$j]["Periode"] ?> <br/>
        <?php endfor; ?>
                </td>
    <?php endfor; ?>
        </tr>
    </table>
    <?php
}

/**
 * Affiche un possible gardien pour une recherche
 * @param array $infos les informations personnelles du gardien
 * @param array $adresse l'adresse du gardien
 */
function afficherGardien($infos, $adresse) {
    ?>
    <fieldset>
        <legend><h4><?= $infos[0]["Prenom"]." ". $infos[0]["Nom"] ?></h4></legend>
        <label>Adresse :</label>
        <p><?= $adresse[0]["NomRue"]." ". $adresse[0]["Numero"] ?> </p>
        <label>Adresse Email :</label>
        <p><?= $infos[0]["Email"] ?></p>
        <label>Description :</label>
        <p> <?= $infos[0]["Description"] ?></p>
    </fieldset>
        <br/>
    <?php
}
