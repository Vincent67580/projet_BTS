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
        $pdo = get_pdo();
        $model = new SignalementModel($pdo);

        // Accès direct depuis la confirmation de création
        if (isset($_SESSION['numeroDossier_nouveau'])) {
            $numeroDossier = $_SESSION['numeroDossier_nouveau'];
            unset($_SESSION['numeroDossier_nouveau']);

            $signalement   = $model->findByNumeroDossier($numeroDossier);
            $piecesJointes = $model->findPiecesJointes($signalement['idSignalement']);
            $_SESSION['signalement_id'] = $signalement['idSignalement'];

            require BASE_PATH . '/app/Views/layout/header.php';
            require BASE_PATH . '/app/Views/Signalement/Signalement.php';
            require BASE_PATH . '/app/Views/layout/footer.php';
            return;
        }

        // Accès via formulaire POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->index();
        }

        $numeroDossier = $_POST['numeroDossier'];
        $mdp = $_POST['motDePasse'];

        $signalement = $model->findDossier($numeroDossier);
        
        if (!$signalement || !password_verify($mdp, $signalement['motDePasse'])) {
            $erreur = "Numéro de dossier ou mot de passe incorrect.";
            return $this->index();
        }

        $signalement   = $model->findByNumeroDossier($numeroDossier);
        $piecesJointes = $model->findPiecesJointes($signalement['idSignalement']);
        $_SESSION['signalement_id'] = $signalement['idSignalement'];
        $_SESSION['fichier_token']  = bin2hex(random_bytes(16));
        session_write_close();

        require BASE_PATH . '/app/Views/layout/header.php';
        require BASE_PATH . '/app/Views/Signalement/Signalement.php';
        require BASE_PATH . '/app/Views/layout/footer.php';
    }

  public function servirFichier() {
    $nomFichier = basename($_GET['fichier'] ?? '');
    $chemin = BASE_PATH . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $nomFichier;

    if (!file_exists($chemin)) {
        http_response_code(404);
        exit('Fichier introuvable');
    }

    // Vide tout output parasite
    while (ob_get_level()) {
        ob_end_clean();
    }
    
    header('Content-Type: image/png');
    header('Content-Length: ' . filesize($chemin));
    flush();
    readfile($chemin);
    exit;
}
}