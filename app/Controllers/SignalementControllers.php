<?php 
// Controller pour la page de consultation de signalement

require_once __DIR__.'/../Models/consulter.php';

class SignalementController {
    public function index() {

        $model= new ConsulterModel();

        return '../Views/Signalement/index.php';
    }
}