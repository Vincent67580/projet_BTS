<!-- Models/consulter.php -->

<?php
session_start();
$timeout = 300; // 5 minutes

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
    session_unset();
    session_destroy();
    include __DIR__.'/../Views/layout/header.php';
    echo 'Session expirée. <br><br> <a href="Models/consulter.php" class="btn">Se reconnecter</a>';
    include __DIR__.'/../Views/layout/footer.php';
    exit;
}

// Permet de réactualiser la duréer de la session sur on navigue de page en page 
if (isset($_SESSION['idSignalement'])) {
    $_SESSION['last_activity'] = time();
}

require_once __DIR__ . '/../Config/db.php';
include __DIR__ . '/../Views/layout/header.php';

$pdo = get_pdo();
$erreur = null;

// Permet de rester identifier lors du retour de la messagerie a la page de consultation
if (isset($_SESSION['idSignalement'])) {

    $stmt = $pdo->prepare('
        SELECT si.idSignalement, si.numeroDossier, ty.libelle AS libelleType, si.contenu,
               st.libelle AS libelleStatus, si.dateDepot, si.estAnonyme,
               si.nom, si.prenom
        FROM Signalements si
        JOIN Status st ON st.idStatus = si.idStatus
        JOIN TypeSignalement ty ON ty.idTypeSignalement = si.idTypeSignalement
        WHERE si.idSignalement = ?
    ');
    $stmt->execute([$_SESSION['idSignalement']]);
    $signalement = $stmt->fetch();

    if ($signalement) {
        include __DIR__ . '/../Views/Signalement/signalement.php';
        include __DIR__.'/../Views/layout/footer.php';
        exit;
    }
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $num = $_POST['numeroDossier'] ?? '';
    $mdp = $_POST['motDePasse'] ?? '';

    $stmt = $pdo->prepare('
        SELECT si.idSignalement, si.numeroDossier, ty.libelle AS libelleType, si.contenu,
               st.libelle AS libelleStatus, si.dateDepot, si.estAnonyme,
               si.nom, si.prenom, si.motDePasse
        FROM Signalements si
        JOIN Status st ON st.idStatus = si.idStatus
        JOIN TypeSignalement ty ON ty.idTypeSignalement = si.idTypeSignalement
        WHERE si.numeroDossier = ?
    ');
    $stmt->execute([$num]);
    $signalement = $stmt->fetch();

    if ($signalement && password_verify($mdp, $signalement['motDePasse'])) {
        $_SESSION['idSignalement'] = $signalement['idSignalement'];
        $_SESSION['last_activity'] = time(); 

        include __DIR__ . '/../Views/Signalement/Signalement.php';
    } else {
        $erreur = "Numéro de dossier ou mot de passe incorrect.";
        include __DIR__ . '/../Views/Depot/connexions.php';
    }


} else {
    include __DIR__ . '/../Views/Depot/connexions.php';
}

