<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../Models/AllSignalementsModel.php';
require_once __DIR__ . '/../Helpers/logHelper.php';

class AllSignalementsController {

    public function index() {
            if (isset($_SESSION['user_id'])) {
                writeLog('CONSULTATION_ALL_SIGNALMENTS', ['user_id' => $_SESSION['user_id']]);
                $pdo = get_pdo();
                $model = new AllSignalementsModel($pdo);
                $signalements = $model->getSignalementsByUser($_SESSION['user_id']);
            require BASE_PATH . '/app/Views/layout/header.php';
            require BASE_PATH . '/app/Views/AllSignalement/allSignalements.php';
            require BASE_PATH . '/app/Views/layout/footer.php';
            // Utilisateur non connecté
        } else {
            header('Location: ' . BASE_URL . 'index.php?page=login');
           
        }
    }
}
