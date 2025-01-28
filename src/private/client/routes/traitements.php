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