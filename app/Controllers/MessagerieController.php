<?php

require_once __DIR__ . '/../Models/MessagerieModel.php';
require_once __DIR__ . '/../Config/db.php';
require_once __DIR__ . '/../Helpers/sessionsHelper.php';
require_once __DIR__ . '/../Helpers/logHelper.php';

class MessagerieController {

    public function index() {
    checkSession();

        $pdo = get_pdo();
        $model = new MessagerieModel($pdo);

        $idSignalement = $_SESSION['signalement_id'];
        
        $messages = $model->getMessages($idSignalement);

        // Envoi d'un message
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contenu = trim($_POST['message'] ?? '');

            if ($contenu !== '') {
                $model->envoyerMessage($idSignalement, $contenu);
                writeLog('MESSAGE_ENVOYE', ['idSignalement' => $idSignalement]);
                header("Location: " . BASE_URL . "index.php?page=messagerie");
                exit;
            }
        }

        $libelleStatus = $_SESSION['libelleStatus'];

        require BASE_PATH . '/app/Views/layout/header.php';

        if ($libelleStatus === 'Traiter') {
            require BASE_PATH . '/app/Views/Messagerie/LogMessagerie.php';
        } else {
            require BASE_PATH . '/app/Views/Messagerie/messagerie.php';
        }

        require BASE_PATH . '/app/Views/layout/footer.php';
    }
}