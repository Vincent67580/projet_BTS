<?php

function checkSession(int $timeout = 300): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
        session_unset();
        session_destroy();

        require BASE_PATH . '/app/Views/layout/header.php';
        echo 'Session expirée.<br><br><a href="/consulter" class="btn">Se reconnecter</a>';
        require BASE_PATH . '/app/Views/layout/footer.php';
        exit;
    }

    if (isset($_SESSION['idSignalement'])) {
        $_SESSION['last_activity'] = time();
    }
}