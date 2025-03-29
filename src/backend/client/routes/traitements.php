<?php

use controllers\Authentification;
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