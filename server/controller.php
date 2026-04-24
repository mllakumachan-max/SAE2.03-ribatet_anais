<?php

/** ARCHITECTURE PHP SERVEUR  : Rôle du fichier controller.php
 * 
 *  Dans ce fichier, on va définir les fonctions de contrôle qui vont traiter les requêtes HTTP.
 *  Les requêtes HTTP sont interprétées selon la valeur du paramètre 'todo' de la requête (voir script.php)
 *  Pour chaque valeur différente, on déclarera une fonction de contrôle différente.
 * 
 *  Les fonctions de contrôle vont éventuellement lire les paramètres additionnels de la requête, 
 *  les vérifier, puis appeler les fonctions du modèle (model.php) pour effectuer les opérations
 *  nécessaires sur la base de données.
 *  
 *  Si la fonction échoue à traiter la requête, elle retourne false (mauvais paramètres, erreur de connexion à la BDD, etc.)
 *  Sinon elle retourne le résultat de l'opération (des données ou un message) à inclure dans la réponse HTTP.
 */

/** Inclusion du fichier model.php
 *  Pour pouvoir utiliser les fonctions qui y sont déclarées et qui permettent
 *  de faire des opérations sur les données stockées en base de données.
 */
require("model.php");


function readMoviesController(){
    $movies = getAllMovies();
    return $movies;
}

/** addMovieController
 * 
 * Cette fonction est en charge du traitement des requêtes HTTP pour lesquelles le paramètre 'todo' vaut 'add'.
 * Elle vérifie si le paramètre titre est défini et non vide dans la requête.
 * Si le paramètre 'titre' est présent, elle appelle la fonction addMovie et ajoute le film.
 * Si le paramètre 'titre' n'est pas présent, vide ou invalide, elle retourne false.
 * 
 * @return mixed Le film si 'titre' est défini, valide et non vide, sinon false.
 */
function addMovieController(){
    // Lecture des données de formulaire
    $titre = $_REQUEST['titre'];
    $annee = $_REQUEST['annee'];
    $duree = $_REQUEST['duree'];
    $desc = $_REQUEST['desc'];
    $real = $_REQUEST['real'];
    $categorie = $_REQUEST['categorie'];
    $img = $_REQUEST['img'];
    $lien = $_REQUEST['lien'];
    $age = $_REQUEST['age'];
    // Vérifie que le paramètre 'titre' n'est pas absent ou vide
    if (isset($titre)==true && empty($titre)==false){
        // Ajout du film à l'aide de la fonction addMovie décrite dans model.php
        addMovie($titre, $annee, $duree, $desc, $real, $categorie, $img, $lien, $age);
        // Vérifie que le paramètre 'age' n'est pas absent ou vide
        if (isset($age)==true && empty($age)==false){
            $min_age = [10, 12, 16, 18];
            if (in_array($age, $min_age)){
                return "Le film $titre a été ajouté avec succès.";
            }
            else{
                return false;
            }
        }
        return "Le film $titre a été ajouté avec succès.";
    }
    else{
        return false;
    }
}