<!-- public/messagerie.php -->

<?php
session_start();
$timeout = 300; // 5 minutes

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
    session_unset();
    session_destroy();
    die("Session expirée. Veuillez vous reconnecter.");
}

$_SESSION['last_activity'] = time();


include __DIR__ . '/../views/layout/header.php';
require_once __DIR__ . '/../src/db.php';

$pdo = get_pdo();


if (!isset($_SESSION['idSignalement'])) {
    die("Accès non autorisé");
}

$idSignalement = $_SESSION['idSignalement'];


$stmt = $pdo->prepare("
    SELECT origine, contenu, dateMessage
    FROM Messagerie
    WHERE idSignalement = ?
    ORDER BY dateMessage ASC
");
$stmt->execute([$idSignalement]);
$messages = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contenu = trim($_POST['message'] ?? '');

    if (!empty($contenu)) {
        $stmt = $pdo->prepare("
            INSERT INTO Messagerie (idSignalement, origine, contenu)
            VALUES (?, 'SIGNALEUR', ?)
        ");
        $stmt->execute([$idSignalement, $contenu]);

        header("Location: messagerie.php");
        exit;
    }
}

include __DIR__ . '/../views/consulter_depot_messagerie.php';


include __DIR__ . '/../views/layout/footer.php';