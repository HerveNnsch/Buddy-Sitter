<?php

/*
 * Auteur: Hervé Neuenschwander
 * But: regroupe toutes les requêtes sql dans des fonction
 */

DEFINE('DB_USER', 'root');
DEFINE('DB_PASSWORD', '');
DEFINE('DB_HOST', '127.0.0.1');
DEFINE('DB_NAME', 'buddysitter');

function maConnexion() {
    static $dbc = null;
    if ($dbc == null) {
        try {
            $dbc = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_PERSISTENT => true));
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            echo'Erreur : ' . $e->getMessage() . '<br/>';
            echo'n° ' . $e->getCode();
            die('could not connect to MySQL');
        }
    }
    return $dbc;
}

/**
 * Insert un nouvel utilisateur avec son adresse
 * @param string $nom nom de l'utilisateur
 * @param string $prenom prenom de l'utilisateur
 * @param string $mdp mot de passe en sha1
 * @param date $naissance date de naissance de l'utilisateur
 * @param string $description description de l'utilisateur
 * @param string $pays le nom du pays
 * @param string $rue le nom avec le type ex: avenue
 * @param string $numero numero de la rue
 * @param string $npa code postal
 * @param int $lat la latitude
 * @param int $lng la longitutde
 * @param string $mail l'adresse email de l'utilisateur
 * @return int id de l'insert
 * @throws PDOException
 */
function inscriptionUtilisateur($nom, $prenom, $mdp, $naissance, $description, $pays, $rue, $numero, $npa, $lat, $lng, $mail) {
    $LastId = insererAdresse($pays, $rue, $numero, $npa, $lat, $lng);
    try {
        $psiUtilisateur = maConnexion()->prepare("INSERT INTO utilisateurs(Nom,Prenom,Mdp,DateNaissance,Description,idAdresse,Email) "
                . "VALUES (:nom,:prenom,:mdp,:naissance,:description,:adresse,:mail);");
        $psiUtilisateur->bindParam(':nom', $nom);
        $psiUtilisateur->bindParam(':prenom', $prenom);
        $psiUtilisateur->bindParam(':mdp', $mdp);
        $psiUtilisateur->bindParam(':naissance', $naissance);
        $psiUtilisateur->bindParam(':description', $description);
        $psiUtilisateur->bindParam(':adresse', $LastId, PDO::PARAM_INT);
        $psiUtilisateur->bindParam(':mail', $mail);
        $psiUtilisateur->execute();
        return maConnexion()->lastInsertId();
    } catch (PDOException $e) {
        throw $e;
    }
}

/**
 * insert une adresse
 * @param string $pays le nom du pays
 * @param string $rue le nom avec le type ex: avenue
 * @param string $numero numero de la rue
 * @param string $npa code postal
 * @param float $lat la latitude
 * @param float $lng la longitutde
 * @return type
 */
function insererAdresse($pays, $rue, $numero, $npa, $lat, $lng) {
    try {
        $psiAdresse = maConnexion()->prepare("INSERT INTO adresses(Numero,NomRue,CodePostal,Pays,Lat,Lng) "
                . "VALUES (:numero,:rue,:npa,:pays,:lat,:lng);");
        $psiAdresse->bindParam(':numero', $numero, PDO::PARAM_STR);
        $psiAdresse->bindParam(':rue', $rue, PDO::PARAM_STR);
        $psiAdresse->bindParam(':npa', $npa, PDO::PARAM_STR);
        $psiAdresse->bindParam(':pays', $pays, PDO::PARAM_STR);
        $psiAdresse->bindParam(':lat', $lat, PDO::PARAM_STR);
        $psiAdresse->bindParam(':lng', $lng, PDO::PARAM_STR);
        $psiAdresse->execute();
        return maConnexion()->lastInsertId();
    } catch (PDOException $e) {
        die('Erreur pendant l\'insertion de l\'adresse');
    }
}

/**
 * verifie la connexion d'un utilisateur
 * @param string $mdp en sha1
 * @param string $nom nom de l'utilisateur
 * @return array tableau associatif si il contient une entrée les infos sont les bonnes
 */
function connexion($mdp, $nom) {
    $pssConnexion = maConnexion()->prepare("SELECT idUtilisateur,Nom,Mdp FROM utilisateurs WHERE Nom = :nom AND Mdp = :mdp");
    $pssConnexion->bindParam(":nom", $nom, PDO::PARAM_STR);
    $pssConnexion->bindparam(":mdp", $mdp, PDO::PARAM_STR);
    $pssConnexion->execute();

    return $pssConnexion->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * récupère toutes les especes
 * @return array
 */
function recupererRaces() {
    try {
        $pssEspeces = maConnexion()->prepare("SELECT * FROM especes");
        $pssEspeces->execute();
        return $pssEspeces->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('Erreur pendant la récupération des races');
    }
}

/**
 * inscrit un nouvel animal
 * @param int $espece l'id de l'espece
 * @param string $nom le nomm de l'animal
 * @param date $naissance la date de niassance de l'animal
 * @param string $remarques les remarques sur l'animal
 * @param int $idUtilisateur l'id du propriétaire
 * @return int l'id de l'insert
 */
function inscriptionAnimal($espece, $nom, $naissance, $remarques, $idUtilisateur) {
    try {
        $psiAnimal = maConnexion()->prepare("INSERT INTO animaux(idEspece,NomAnimal,DateNaissanceAnimal,Remarques,idUtilisateur) "
                . "VALUES (:espece,:nom,:naissance,:remarques,:id);");
        $psiAnimal->bindParam(':nom', $nom, PDO::PARAM_STR);
        $psiAnimal->bindParam(':naissance', $naissance, PDO::PARAM_STR);
        $psiAnimal->bindParam(':espece', $espece, PDO::PARAM_STR);
        $psiAnimal->bindParam(':remarques', $remarques, PDO::PARAM_STR);
        $psiAnimal->bindParam(':id', $idUtilisateur, PDO::PARAM_STR);
        $psiAnimal->execute();
        return maConnexion()->lastInsertId();
    } catch (PDOException $e) {
        die('Erreur pendant l\'inscription de l\'animal');
    }
}

/**
 * récupere toutes les infos d'un utilisateur suivant son id
 * @param int $idUtilisateur
 * @return array tableau associatif
 */
function recupererUtilisateur($idUtilisateur) {
    try {
        $pssUtilisateur = maConnexion()->prepare("SELECT * FROM utilisateurs WHERE idUtilisateur = :id");
        $pssUtilisateur->bindParam(':id', $idUtilisateur, PDO::PARAM_INT);
        $pssUtilisateur->execute();
        return $pssUtilisateur->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('Erreur pendant la récupération de l\'utilisateur');
    }
}

/**
 * récupere les infos des animaux d'un utilisateur
 * @param int $idUtilisateur
 * @return array tableau associatif
 */
function recupererAnimauxDepuisUtilisateur($idUtilisateur) {
    try {
        $pssAnimal = maConnexion()->prepare("SELECT * FROM animaux WHERE idUtilisateur = :id");
        $pssAnimal->bindParam(':id', $idUtilisateur, PDO::PARAM_INT);
        $pssAnimal->execute();
        return $pssAnimal->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('Erreur pendant la récupération de l\'animal depuis l\'utilisateur');
    }
}

/**
 * recupère toutes les infos d'un animal depuis son id
 * @param int $idAnimal
 * @return array tableau associatif 
 */
function recupererAnimal($idAnimal) {
    try {
        $pssAnimal = maConnexion()->prepare("SELECT * FROM animaux WHERE idAnimal = :id");
        $pssAnimal->bindParam(':id', $idAnimal, PDO::PARAM_INT);
        $pssAnimal->execute();
        return $pssAnimal->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('Erreur pendant la récupération de l\'animal');
    }
}

/**
 * récupère toutes les infos d'une adresse depuis son id
 * @param int $idAdresse
 * @return array tableau associatif 
 */
function recupererAdresse($idAdresse) {
    try {
        $pssAdresse = maConnexion()->prepare("SELECT * FROM adresses WHERE idAdresse = :id");
        $pssAdresse->bindParam(':id', $idAdresse, PDO::PARAM_INT);
        $pssAdresse->execute();
        return $pssAdresse->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('Erreur pendant la récupération de l\'adresse');
    }
}

/**
 * récupère toutes les horaires
 * @return array tableau associatif 
 */
function recupererHoraires() {
    try {
        $pssHoraire = maConnexion()->prepare("SELECT * FROM horaires;");
        $pssHoraire->execute();
        return $pssHoraire->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('Erreur pendant la récupération des horaires');
    }
}

/**
 * insert les disponibilités pour un utilisateur
 * @param int $idHoraire id de l'horaire
 * @param int $idUtilisateur id d el'utilisateur
 * @return int l'id de l'insert
 */
function insererDisponibilites($idHoraire, $idUtilisateur) {
    try {
        $psiDisponibilites = maConnexion()->prepare("INSERT INTO disponible(idHoraire,idUtilisateur) VALUES(:idHoraire, :idUtilisateur)");
        $psiDisponibilites->bindParam(':idHoraire', $idHoraire, PDO::PARAM_INT);
        $psiDisponibilites->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        $psiDisponibilites->execute();
        return maConnexion()->lastInsertId();
    } catch (PDOException $e) {
        die('Erreur pendant l\'enregistrement des disponibilités');
    }
}

/**
 * supprime les disponibilités d'un utilisateur
 * @param type $idUtilisateur
 */
function deleteDisponibilites($idUtilisateur) {
    /* $test = maConnexion()->query("SELECT * FROM disponible WHERE idUtilisateur = " . $idUtilisateur);
      $test->fetchAll(PDO::FETCH_ASSOC);
      if (count($test) != 0) { */
    $delete = maConnexion()->query("DELETE FROM disponible WHERE idUtilisateur = " . $idUtilisateur);
    //}
}

/**
 * supprime les race gardable pour l'utilisateur 
 * @param int $idUtilisateur id de l'utilisateur
 */
function supprimerChoixRaces($idUtilisateur) {
    $delete = maConnexion()->query("DELETE FROM peut_garder WHERE idUtilisateur = " . $idUtilisateur);
}

/**
 * insert une race qu'un gardien peut garder
 * @param int $idEspece id de la race
 * @param int $idUtilisateur id de l'utilisateur
 * @return in id du dernier insert
 */
function insererChoixRace($idEspece, $idUtilisateur) {
    try {
        $psiDisponibilites = maConnexion()->prepare("INSERT INTO peut_garder(idEspece,idUtilisateur) VALUES(:idEspece, :idUtilisateur)");
        $psiDisponibilites->bindParam(':idEspece', $idEspece);
        $psiDisponibilites->bindParam(':idUtilisateur', $idUtilisateur);
        $psiDisponibilites->execute();
        return maConnexion()->lastInsertId();
    } catch (PDOException $e) {
        die('Erreur pendant l\'inscription des races gardables');
    }
}

/**
 * recupère les disponibilités d'un utilisateur
 * @param int $id id de l'utilisateur
 * @return array tableau associatif
 */
function recupererDisponibilités($id) {
    try {
        $pssHoraire = maConnexion()->prepare("SELECT idHoraire FROM disponible WHERE idUtilisateur = :id");
        $pssHoraire->bindParam(':id', $id, PDO::PARAM_INT);
        $pssHoraire->execute();
        return $pssHoraire->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('Erreur pendant la récupération des disponibilités');
    }
}

/**
 * modifie une adresse
 * @param string $numero numero de la rue
 * @param string $rue nom de la rue
 * @param string $npa code postal
 * @param string $pays nom du pays
 * @param int $lat la latitude
 * @param int $lng la longitude
 * @param int $id l'id de l'adresse à modifier
 */
function modifierAdresse($numero, $rue, $npa, $pays, $lat, $lng, $id) {
    $psuAdresse = maConnexion()->prepare("UPDATE adresses "
            . "SET Numero=:numero, NomRue=:rue, CodePostal=:npa, Pays=:pays, Lat=:lat, Lng=:lng "
            . "WHERE idAdresse = :id");
    $psuAdresse->bindParam(":numero", $numero);
    $psuAdresse->bindParam(":rue", $rue);
    $psuAdresse->bindParam(":npa", $npa);
    $psuAdresse->bindParam(":pays", $pays);
    $psuAdresse->bindParam(":lat", $lat);
    $psuAdresse->bindParam(":lng", $lng);
    $psuAdresse->bindParam(":id", $id);
    $psuAdresse->execute();
}

/**
 * modifie un utilisateur
 * @param string $nom nom de l'utilisateur
 * @param string $prenom prenom de l'utilisateur
 * @param string $mdp mot de passe en sha1
 * @param date $naissance date de naissance
 * @param string $description description d el'utilisateur
 * @param int $idUtlisateur id de l'utilisateur à modifier
 * @param string $email adresse email de l'utilisateur
 */
function modifierUtilisateur($nom, $prenom, $mdp, $naissance, $description, $idUtlisateur, $email) {
    $psuUtilisateur = maConnexion()->prepare("UPDATE utilisateurs "
            . "SET Nom=:nom, Prenom=:prenom, Mdp=:mdp, DateNaissance=:naissance, Description=:description, Email=:email "
            . "WHERE idUtilisateur = :id");
    $psuUtilisateur->bindParam(':nom', $nom);
    $psuUtilisateur->bindParam(':prenom', $prenom);
    $psuUtilisateur->bindParam(':mdp', $mdp);
    $psuUtilisateur->bindParam(':naissance', $naissance);
    $psuUtilisateur->bindParam(':description', $description);
    $psuUtilisateur->bindParam(':id', $idUtlisateur);
    $psuUtilisateur->bindParam(':email', $email);
    $psuUtilisateur->execute();
}

/**
 * modifie un animal
 * @param string $nom nom de l'animal
 * @param date $naissance date de naissance de l'animal
 * @param string $remarque remarques sur l'animal
 * @param int $espece id de l'espèce de l'animal
 * @param int $idAnimal id de l'animal à modifier
 */
function modifierAnimal($nom, $naissance, $remarque, $espece, $idAnimal) {
    $psuAnimaux = maConnexion()->prepare("UPDATE animaux "
            . "SET NomAnimal=:nom, DateNaissanceAnimal=:naissance, Remarques=:remarques, idEspece=:espece "
            . "WHERE idAnimal = :id");
    $psuAnimaux->bindParam(':nom', $nom);
    $psuAnimaux->bindParam(':naissance', $naissance);
    $psuAnimaux->bindParam(':remarques', $remarque);
    $psuAnimaux->bindParam(':espece', $espece);
    $psuAnimaux->bindParam(':id', $idAnimal);
    $psuAnimaux->execute();
}

function recupererEspeceGardable($idutilisateur) {
    try {
        $pssEspeces = maConnexion()->prepare("SELECT idEspece FROM peut_garder WHERE idUtilisateur=:id");
        $pssEspeces->bindParam(':id', $idutilisateur);
        $pssEspeces->execute();
        return $pssEspeces->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException$e) {
        die("erreur pendant la récupération des éspèces gardables");
    }
}

function rechercherGardien($dispos,$idEspece,$lat,$lng){
    $ids = implode(",", $dispos);
    str_replace('"', '', $ids);
    try {
        $pssEspeces = maConnexion()->prepare("SELECT * FROM recherche WHERE idHoraire IN (" . $ids . ") AND idEspece = :idEspece GROup BY idUtilisateur");
        $pssEspeces->bindParam(':idEspece', $idEspece);
        $pssEspeces->execute();
        return $pssEspeces->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException$e) {
        throw $e;
    }
}
