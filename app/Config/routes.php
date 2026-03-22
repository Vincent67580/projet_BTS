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
];

