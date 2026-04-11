<?php

//Appel des routes pour le projet

return [
    //route pour la page d'accueil
    'home'                  => 'HomeController@index',
    //route pour la page de dépôt de signalement
    'depot'                 => 'DepotController@index',
    'depotInsert'           => 'DepotController@depot',
    'confirmation'          => 'DepotController@confirmationDepot',
    //route pour la page de consultation de signalement
    'signalement'           => 'SignalementController@index',
    'signalementConnexions' => 'SignalementController@connexions',
    'fichier'               => 'SignalementController@servirFichier',
    'consultation'          => 'SignalementController@consultation',
    //route pour la page de messagerie
    'messagerie'           => 'MessagerieController@index',
    //route compte
    'login'                 => 'SignaleurController@login',
    'inscription'           => 'SignaleurController@inscription',
    'logout'                => 'SignaleurController@logout',
    //route pour la page de tout les signalements d'un signaleur
    'AllSignalements'       => 'AllSignalementsController@index',
];

