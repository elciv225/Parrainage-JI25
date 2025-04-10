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
Route::post('/vote/projet/:id', function ($id){
    Concours::voteProjet($id);
},'traitement_vote');

// Traitemennt des votes pour le roi
Route::post('/vote/roi/:id', function ($id){
    Concours::voteRoi($id);
},'traitement_vote_roi');
// Traitemennt des votes pour la reine
Route::post('/vote/reine/:id', function ($id){
    Concours::voteReine($id);
},'traitement_vote_reine');

// Traitement pour poser des questions
Route::post('/poser/question', function (){
    Authentification::poserQuestion();
},'traitement_question');

// Traitement pour commander un repas
Route::post('/commander/repas/:id', function ($id){
    Authentification::commanderRepas();
},'traitement_commande_repas');