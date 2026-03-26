<?php

function checkSession(int $timeout = 900): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Pas de session active
    if (!isset($_SESSION['signalement_id'])) {
        header('Location: ' . BASE_URL . 'index.php?page=signalementConnexions');
        exit;
    }

    // Session expirée après 15 min d'inactivité
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . 'index.php?page=signalementConnexions&expire=1');
        exit;
    }

    // Met à jour l'activité
    $_SESSION['last_activity'] = time();
}