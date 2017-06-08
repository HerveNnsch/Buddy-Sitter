<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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

function inscriptionUtilisateur($nom, $prenom, $mdp, $naissance, $description, $pays, $rue, $numero, $npa, $lat, $lng,$mail) {
    $LastId = insererAdresse($pays, $rue, $numero, $npa, $lat, $lng);
    try {
        $psiUtilisateur = maConnexion()->prepare("INSERT INTO utilisateurs(Nom,Prenom,Mdp,DateNaissance,Description,idAdresse,Email) "
                . "VALUES (:nom,:prenom,:mdp,:naissance,:description,:adresse,:mail);");
        $psiUtilisateur->bindParam(':nom', $nom);
        $psiUtilisateur->bindParam(':prenom', $prenom);
        $psiUtilisateur->bindParam(':mdp', $mdp);
        $psiUtilisateur->bindParam(':naissance', $naissance);
        $psiUtilisateur->bindParam(':description', $description);
        $psiUtilisateur->bindParam(':adresse', $LastId,PDO::PARAM_INT);
        $psiUtilisateur->bindParam(':mail', $mail);
        $psiUtilisateur->execute();
        return maConnexion()->lastInsertId();
    } catch (PDOException $e) {
        throw $e;
    }
}

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

function connexion($mdp, $nom) {
    $pssConnexion = maConnexion()->prepare("SELECT idUtilisateur,Nom,Mdp FROM utilisateurs WHERE Nom = :nom AND Mdp = :mdp");
    $pssConnexion->bindParam(":nom", $nom, PDO::PARAM_STR);
    $pssConnexion->bindparam(":mdp", $mdp, PDO::PARAM_STR);
    $pssConnexion->execute();

    return $pssConnexion->fetchAll(PDO::FETCH_ASSOC);
}

function recupererRaces() {
    try {
        $pssEspeces = maConnexion()->prepare("SELECT * FROM especes");
        $pssEspeces->execute();
        return $pssEspeces->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('Erreur pendant la récupération des races');
    }
}

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

function recupererAdresse($idAdresse) {
    try {
        $pssUtilisateur = maConnexion()->prepare("SELECT * FROM adresses WHERE idAdresse = :id");
        $pssUtilisateur->bindParam(':id', $idAdresse, PDO::PARAM_INT);
        $pssUtilisateur->execute();
        return $pssUtilisateur->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('Erreur pendant la récupération de l\'adresse');
    }
}

function recupererHoraires(){
    try {
        $pssAnimal = maConnexion()->prepare("SELECT * FROM horaires;");
        $pssAnimal->execute();
        return $pssAnimal->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('Erreur pendant la récupération des horaires');
    }
}

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

function deleteDisponibilites($idUtilisateur) {
    $test = maConnexion()->query("SELECT * FROM disponible WHERE idUtilisateur = " . $idUtilisateur);
    $test->fetchAll(PDO::FETCH_ASSOC);
    if (count($test) != 0) {
        $delete = maConnexion()->query("DELETE FROM disponible WHERE idUtilisateur = " . $idUtilisateur);
    }
}

function insererChoixRace($idEspece, $idUtilisateur) {
    $delete=  maConnexion()->query("DELETE FROM peut_garder WHERE idUtilisateur = ".$idUtilisateur);
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

function recupererDisponibilités($id){
    try {
        $pssUtilisateur = maConnexion()->prepare("SELECT idHoraire FROM disponible WHERE idUtilisateur = :id");
        $pssUtilisateur->bindParam(':id', $id, PDO::PARAM_INT);
        $pssUtilisateur->execute();
        return $pssUtilisateur->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('Erreur pendant la récupération des disponibilités');
    }
}

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

function modifierAnimal($nom, $naissance, $remarque, $espece,$idAnimal) {
    $psuUtilisateur = maConnexion()->prepare("UPDATE animaux "
            . "SET NomAnimal=:nom, DateNaissanceAnimal=:naissance, Remarques=:remarques, idEspece=:espece "
            . "WHERE idAnimal = :id");
    $psuUtilisateur->bindParam(':nom', $nom);
    $psuUtilisateur->bindParam(':naissance', $naissance);
    $psuUtilisateur->bindParam(':remarques', $remarque);
    $psuUtilisateur->bindParam(':espece', $espece);
    $psuUtilisateur->bindParam(':id', $idAnimal);
    $psuUtilisateur->execute();
}