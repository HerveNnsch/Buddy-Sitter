<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
        <a href='modifierinformations.php?id=<?= $infos[0]["idUtilisateur"]?>'>Modifier</a>
    </fieldset>
    <?php
}

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

function afficherEspeces($infos) {
    ?>
    <label>Espèces:</label><br/>
    <?php foreach ($infos as $animal) : ?>
        <input type='checkbox' name='espece[]' value='<?= $animal["idEspece"] ?>'><?= $animal["NomEspece"] ?><br/>
    <?php
    endforeach;
}

/*function afficherTableauDisponibilités() {
    ?>
    <table border="1">
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
            <td>
                <input type="checkbox" name="disponible[]" value="1"> Matin<br>
                <input type="checkbox" name="disponible[]" value="2"> Après-midi<br>
                <input type="checkbox" name="disponible[]" value="3"> Soir
            </td>
            <td>
                <input type="checkbox" name="disponible[]" value="4"> Matin<br>
                <input type="checkbox" name="disponible[]" value="5"> Après-midi<br>
                <input type="checkbox" name="disponible[]" value="6"> Soir
            </td>
            <td>
                <input type="checkbox" name="disponible[]" value="7"> Matin<br>
                <input type="checkbox" name="disponible[]" value="8"> Après-midi<br>
                <input type="checkbox" name="disponible[]" value="9"> Soir
            </td>
            <td>
                <input type="checkbox" name="disponible[]" value="10"> Matin<br>
                <input type="checkbox" name="disponible[]" value="11"> Après-midi<br>
                <input type="checkbox" name="disponible[]" value="12"> Soir
            </td>
            <td>
                <input type="checkbox" name="disponible[]" value="13"> Matin<br>
                <input type="checkbox" name="disponible[]" value="14"> Après-midi<br>
                <input type="checkbox" name="disponible[]" value="15"> Soir
            </td>
            <td>
                <input type="checkbox" name="disponible[]" value="16"> Matin<br>
                <input type="checkbox" name="disponible[]" value="17"> Après-midi<br>
                <input type="checkbox" name="disponible[]" value="18"> Soir
            </td>
            <td>
                <input type="checkbox" name="disponible[]" value="19"> Matin<br>
                <input type="checkbox" name="disponible[]" value="20"> Après-midi<br>
                <input type="checkbox" name="disponible[]" value="21"> Soir
            </td>
        </tr>
    </table>
    <?php
}*/

/*function afficherDisponibilites($infos){
    $idHoraire;
    foreach ($infos as $id) {
        $idHoraire[]=$id["idHoraire"];
    }
    ?>
    <table border="1">
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
            <td>
                <input type="checkbox" name="disponible[]" onclick="return false" value="1" <?php if(in_array('1', $idHoraire)) {echo"checked";} ?>> Matin<br>
                <input type="checkbox" name="disponible[]" onclick="return false" value="2" <?php if(in_array('2', $idHoraire)) {echo"checked";} ?>> Après-midi<br>
                <input type="checkbox" name="disponible[]" onclick="return false" value="3" <?php if(in_array('3', $idHoraire)) {echo"checked";} ?>> Soir
            </td>
            <td>
                <input type="checkbox" name="disponible[]" onclick="return false" value="4" <?php if(in_array('4', $idHoraire)) {echo"checked";} ?>> Matin<br>
                <input type="checkbox" name="disponible[]" onclick="return false" value="5" <?php if(in_array('5', $idHoraire)) {echo"checked";} ?>> Après-midi<br>
                <input type="checkbox" name="disponible[]" onclick="return false" value="6" <?php if(in_array('6', $idHoraire)) {echo"checked";} ?>> Soir
            </td>
            <td>
                <input type="checkbox" name="disponible[]" onclick="return false" value="7" <?php if(in_array('7', $idHoraire)) {echo"checked";} ?>> Matin<br>
                <input type="checkbox" name="disponible[]" onclick="return false" value="8" <?php if(in_array('8', $idHoraire)) {echo"checked";} ?>> Après-midi<br>
                <input type="checkbox" name="disponible[]" onclick="return false" value="9" <?php if(in_array('9', $idHoraire)) {echo"checked";} ?>> Soir
            </td>
            <td>
                <input type="checkbox" name="disponible[]" onclick="return false" value="10" <?php if(in_array('10', $idHoraire)) {echo"checked";} ?>> Matin<br>
                <input type="checkbox" name="disponible[]" onclick="return false" value="11" <?php if(in_array('11', $idHoraire)) {echo"checked";} ?>> Après-midi<br>
                <input type="checkbox" name="disponible[]" onclick="return false" value="12" <?php if(in_array('12', $idHoraire)) {echo"checked";} ?>> Soir
            </td>
            <td>
                <input type="checkbox" name="disponible[]" onclick="return false" value="13" <?php if(in_array('13', $idHoraire)) {echo"checked";} ?>> Matin<br>
                <input type="checkbox" name="disponible[]" onclick="return false" value="14" <?php if(in_array('14', $idHoraire)) {echo"checked";} ?>> Après-midi<br>
                <input type="checkbox" name="disponible[]" onclick="return false" value="15" <?php if(in_array('15', $idHoraire)) {echo"checked";} ?>> Soir
            </td>
            <td>
                <input type="checkbox" name="disponible[]" onclick="return false" value="16" <?php if(in_array('16', $idHoraire)) {echo"checked";} ?>> Matin<br>
                <input type="checkbox" name="disponible[]" onclick="return false" value="17" <?php if(in_array('17', $idHoraire)) {echo"checked";} ?>> Après-midi<br>
                <input type="checkbox" name="disponible[]" onclick="return false" value="18" <?php if(in_array('18', $idHoraire)) {echo"checked";} ?>> Soir
            </td>
            <td>
                <input type="checkbox" name="disponible[]" onclick="return false" value="19" <?php if(in_array('19', $idHoraire)) {echo"checked";} ?>> Matin<br>
                <input type="checkbox" name="disponible[]" onclick="return false" value="20" <?php if(in_array('20', $idHoraire)) {echo"checked";} ?>> Après-midi<br>
                <input type="checkbox" name="disponible[]" onclick="return false" value="21" <?php if(in_array('21', $idHoraire)) {echo"checked";} ?>> Soir
            </td>
        </tr>
    </table>
        <a href='modifierdisponibilites.php'>Modifier</a>
        <?php
}*/

function afficherDisponibilitesDeux($disponible,$horaires,$modif){
    $idHoraire=[];
    foreach ($disponible as $id) {
        $idHoraire[]=$id["idHoraire"];
    }?>
        <table border='1'>
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
                <?php for($i=0;$i<count($horaires);$i+=3):?>
                <td>
                    <?php for($j=$i;$j<$i+3;$j++):?>
                        <input type="checkbox" name="disponible[]" onclick="<?php if(!$modif){echo "return false";} ?>" value="<?= $horaires[$j]["idHoraire"] ?>" <?php if(in_array($horaires[$j]["idHoraire"], $idHoraire)) {echo"checked";} ?> > <?= $horaires[$j]["Periode"]?> <br/>
                 <?php endfor;?>
                </td>
                <?php endfor;?>
            </tr>
        </table>
        <?php
}