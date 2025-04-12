<?php

use controllers\Authentification;
use controllers\Concours;
use config\Route;

// Traitement d'inscription
Route::post('/inscription', function (){
   Authentification::inscription();
},'traitement_inscription');

// Traitement de connexion
Route::post('/connexion', function (){
    Authentification::connexion();
},'traitement_connexion');

// Traitement de déconnexion
Route::get('/deconnexion', function (){
    Authentification::deconnexion();
},'traitement_deconnexion');

// Traitemennt des votes pour le mpc
Route::post('/vote/projet', function () {
    Concours::voteProjet();
}, 'traitement_vote_projet');

Route::post('/vote/roi', function () {
    Concours::voteRoi();
}, 'vote_roi');

Route::post('/vote/reine', function () {
    Concours::voteReine();
}, 'vote_reine');


// Traitement pour poser des questions
Route::post('/poser/question', function (){
    Authentification::poserQuestion();
},'traitement_question');

// Traitement pour commander un repas
Route::post('/commander/repas/:id', function ($id){
    Authentification::commanderRepas();
},'traitement_commande_repas');