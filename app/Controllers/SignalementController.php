<?php 
// Controller pour la page de consultation de signalement

require_once __DIR__.'/../Models/SignalementModel.php';
require_once __DIR__.'/../Helpers/sessionsHelper.php';

class SignalementController {
    public function index() {

        require BASE_PATH . '/app/Views/layout/header.php';
        require BASE_PATH . '/app/Views/Signalement/connexions.php';
        require BASE_PATH . '/app/Views/layout/footer.php';

       
    }

    public function connexions() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->index();
        }

        $pdo = get_pdo();
        $model = new SignalementModel($pdo);

        $numeroDossier = $_POST['numeroDossier'];
        $mdp = $_POST['mdp'];

        $signalement = $model->getSignalementByNumeroDossier($numeroDossier);
        if (!$signalement || !password_verify($mdp, $signalement['motDePasse'])) {
            $erreur = "Numéro de dossier ou mot de passe incorrect.";
            require BASE_PATH . '/app/Views/layout/header.php';
            require BASE_PATH . '/app/Views/Signalement/connexions.php';
            require BASE_PATH . '/app/Views/layout/footer.php';
            return;
        }

        // Stockage de l'ID du signalement en session pour la page de consultation
        $_SESSION['signalement_id'] = $signalement['id'];

        // Redirection vers la page de consultation du signalement
        header('Location: ' . BASE_URL . 'index.php?page=signalement');
        exit;
    }
}