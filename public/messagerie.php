<!-- public/messagerie.php -->

<?php
session_start();
$timeout = 300; // 5 minutes

/* 1️ Expiration de session */
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
    session_unset();
    session_destroy();

    include __DIR__.'/../views/layout/header.php';
    echo 'Session expirée.<br><br><a href="consulter.php" class="btn">Se reconnecter</a>';
    include __DIR__.'/../views/layout/footer.php';
    exit;
}

/* 2️ Accès interdit si non connecté */
if (!isset($_SESSION['idSignalement'])) {
    include __DIR__.'/../views/layout/header.php';
    echo 'Accès non autorisé.<br><br><a href="consulter.php">Retour</a>';
    include __DIR__.'/../views/layout/footer.php';
    exit;
}

/* 3️ Mise à jour de l’activité */
$_SESSION['last_activity'] = time();

require_once __DIR__ . '/../src/db.php';
include __DIR__ . '/../views/layout/header.php';

$pdo = get_pdo();
$idSignalement = $_SESSION['idSignalement'];

/* 4️ Récupération des messages */
$stmt = $pdo->prepare("
    SELECT origine, contenu, dateMessage
    FROM Messagerie
    WHERE idSignalement = ?
    ORDER BY dateMessage ASC
");
$stmt->execute([$idSignalement]);
$messages = $stmt->fetchAll();

/* 5️ Envoi du message */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contenu = trim($_POST['message'] ?? '');

    if ($contenu !== '') {
        $stmt = $pdo->prepare("
            INSERT INTO Messagerie (idSignalement, origine, contenu)
            VALUES (?, 'SIGNALEUR', ?)
        ");
        $stmt->execute([$idSignalement, $contenu]);

        /* PRG : Post → Redirect → Get */
        header("Location: messagerie.php");
        exit;
    }
}

if($_SESSION['libelleStatus']==='Traiter'):
    include __DIR__ . '/../views/consulter_messagerie.php';
else:
    include __DIR__ . '/../views/consulter_depot_messagerie.php';
endif;

include __DIR__ . '/../views/layout/footer.php';
