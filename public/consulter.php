<!-- public/consulter.php -->

<?php
$pageCSS = 'consulter.css';
include __DIR__ . '/../views/layout/header.php';
require_once __DIR__ . '/../src/db.php';

$pdo = get_pdo();

$erreur = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $num = $_POST['numeroDossier'] ?? '';
    $mdp = $_POST['motDePasse'] ?? '';

    $stmt = $pdo->prepare('
        SELECT si.numeroDossier, ty.libelle AS libelleType, si.contenu,
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
        include __DIR__ . '/../views/consulter_affichage.php';
    } else {
        $erreur = "Numéro de dossier ou mot de passe incorrect.";
        include __DIR__ . '/../views/consulter_form.php';
    }


} else {
    include __DIR__ . '/../views/consulter_form.php';
}

include __DIR__.'/../views/layout/footer.php';
