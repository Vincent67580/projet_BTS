<?php 
// Controller pour la page de consultation de signalement

require_once __DIR__.'/../Models/consulter.php';
require_once __DIR__.'/../Helpers/sessionsHelper.php';

class SignalementController {
    public function index() {

        require BASE_PATH . '/app/Views/layout/header.php';
        require BASE_PATH . '/app/Views/Depot/connexions.php';
        require BASE_PATH . '/app/Views/layout/footer.php';

       /* $model= new ConsulterModel();

        checkSession();

        $data = [
            'signalement' => $model->getSignalement()
        ];

        require ('app/Views/Signalement/signalement.php', $data);*/
    }
}