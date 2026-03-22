<?php 
require_once __DIR__.'/../Models/SignalementModel.php';
require_once __DIR__.'/../Helpers/sessionsHelper.php';
require_once __DIR__.'/../Config/db.php';   

class SignalementController {

    public function index() {
        require BASE_PATH . '/app/Views/layout/header.php';
        require BASE_PATH . '/app/Views/Signalement/connexions.php';
        require BASE_PATH . '/app/Views/layout/footer.php';
    }

    public function connexions() {
        // Accès direct depuis la confirmation de création
    if (isset($_SESSION['numeroDossier_nouveau'])) {
        $numeroDossier = $_SESSION['numeroDossier_nouveau'];
        unset($_SESSION['numeroDossier_nouveau']); // on nettoie

        $pdo = get_pdo();
        $model = new SignalementModel($pdo);

        $signalement   = $model->findByNumeroDossier($numeroDossier);
        $piecesJointes = $model->findPiecesJointes($signalement['idSignalement']);

        require BASE_PATH . '/app/Views/layout/header.php';
        require BASE_PATH . '/app/Views/Signalement/Signalement.php';
        require BASE_PATH . '/app/Views/layout/footer.php';
        return;
    }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->index();
        }

        $pdo = get_pdo();
        $model = new SignalementModel($pdo);

        $numeroDossier = $_POST['numeroDossier'];
        $mdp = $_POST['motDePasse'];

        $signalement = $model->findDossier($numeroDossier);
        
        if (!$signalement || !password_verify($mdp, $signalement['motDePasse'])) {
            $erreur = "Numéro de dossier ou mot de passe incorrect.";
            // $erreur est accessible dans la vue index
            return $this->index();
        }

        $_SESSION['signalement_id'] = $signalement['idSignalement'];

        $signalement = $model->findByNumeroDossier($numeroDossier);
        $piecesJointes = $model->findPiecesJointes($signalement['idSignalement']);

        // On inclut directement la vue — $connexions y est accessible
        require BASE_PATH . '/app/Views/layout/header.php';
        require BASE_PATH . '/app/Views/Signalement/signalement.php';
        require BASE_PATH . '/app/Views/layout/footer.php';
    }
}