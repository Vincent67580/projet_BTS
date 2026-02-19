<?php 

require_once __DIR__ . '/../Config/db.php';

//Verifie si la session est active et si l'utilisateur est connecté
function checkSession() {

    $timeout = 300; // 5 minutes

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
    session_unset();
    session_destroy();
    include __DIR__.'/../Views/layout/header.php';
    echo 'Session expirée. <br><br> <a href="Models/consulter.php" class="btn">Se reconnecter</a>';
    include __DIR__.'/../Views/layout/footer.php';
    exit;
}
}