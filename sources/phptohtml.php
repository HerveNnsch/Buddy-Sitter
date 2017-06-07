<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function afficherUtilisateur($infos) {
    ?>
    <fieldset>
        <legend>Informations personnelles</legend>
        <label>Nom: <?= $infos[0]["Nom"] ?></label>
        <label>Prénom: <?= $infos[0]["Prenom"] ?></label>
        <label>Date de naissance: <?= $infos[0]["DateNaissance"] ?></label>
        <label>Email: <?= $infos[0]["Email"] ?></label>
        <label>Description: <?= $infos[0]["Description"] ?></label>
    </fieldset>
    <?php
}

function afficherAdresse($infos) {
    ?>
    <fieldset>
        <legend>Adresse</legend>
        <label>Rue: <?= $infos[0]["NomRue"] ?></label>
        <label>Numéro: <?= $infos[0]["Numero"] ?></label>
        <label>CodePostal: <?= $infos[0]["CodePostal"] ?></label>
        <label>Pays: <?= $infos[0]["Pays"] ?></label>
    </fieldset>
    <?php
}

function afficherAnimaux($infos,$especes) {
    ?>
    <table>
        <tr>
            <td>Nom</td>
            <td>Espèce</td>
            <td>Date de naissance</td>
            <td>Remarques</td>
        </tr>
        <?php foreach ($infos as $animal) : ?>
        <tr>
            <td><?= $animal["NomAnimal"]?></td>
            <td><?= $especes[$animal["idEspece"]-1]["NomEspece"]?></td>
            <td><?= $animal["DateNaissanceAnimal"]?></td>
            <td><?= $animal["Remarques"]?></td>
        </tr>

        <?php endforeach; ?>
    </table>

    <?php
}
